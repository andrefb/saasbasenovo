<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Services\CloudinaryService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;

class EditCompanyProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Dados da Empresa';
    }

    public static function getSlug(?\Filament\Panel $panel = null): string
    {
        return 'company';
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                // LOGO DA EMPRESA
                Section::make('Logo da Empresa')
                    ->schema([
                        FileUpload::make('logo_upload')
                            ->label('Enviar Nova Logo')
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048) // 2MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->disk('local')
                            ->directory('temp-uploads')
                            ->visibility('private')
                            ->helperText('Formatos: JPG, PNG, WebP, SVG. Máximo: 2MB. Clique em Salvar para enviar.'),
                        
                        TextInput::make('logo_url')
                            ->label('URL da Logo Atual')
                            ->readOnly()
                            ->dehydrated(true)
                            ->helperText('URL no Cloudinary (gerada ao salvar)'),
                    ])
                    ->columns(2),

                // IDENTIFICAÇÃO
                Section::make('Identificação')
                    ->schema([
                        ComponentsGrid::make(2)->schema([
                            TextInput::make('cnpj')
                                ->mask('99.999.999/9999-99')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $this->consultaCNPJ($state, $set);
                                })
                                ->helperText('Ao preencher, os dados serão buscados automaticamente'),

                            TextInput::make('inscricao_estadual')
                                ->label('Inscrição Estadual'),
                        ]),

                        TextInput::make('legal_name')
                            ->label('Razão Social'),

                        ComponentsGrid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nome Fantasia')
                                ->required(),

                            TextInput::make('slug')
                                ->label('URL do Sistema')
                                ->required()
                                ->suffix('.' . config('app.domain'))
                                ->unique('companies', 'slug', ignoreRecord: true)
                                ->validationMessages([
                                    'unique' => 'Este endereço já está sendo usado por outra empresa.',
                                ])
                                ->helperText('Será o endereço de acesso da empresa'),
                        ]),
                    ]),

                // CONTATO
                Section::make('Contato')
                    ->schema([
                        ComponentsGrid::make(2)->schema([
                            TextInput::make('email')
                                ->label('E-mail')
                                ->email(),

                            TextInput::make('website')
                                ->label('Website')
                                ->prefix('https://')
                                ->placeholder('seusite.com.br')
                                ->helperText('Digite apenas o domínio, sem http:// ou www'),
                        ]),

                        ComponentsGrid::make(2)->schema([
                            TextInput::make('phone_1')
                                ->label('Telefone 1')
                                ->tel()
                                ->mask('(99) 99999-9999')
                                ->placeholder('(11) 99999-9999'),

                            TextInput::make('phone_2')
                                ->label('Telefone 2')
                                ->tel()
                                ->mask('(99) 99999-9999')
                                ->placeholder('(11) 99999-9999'),
                        ]),
                    ]),

                // ENDEREÇO
                Section::make('Endereço')
                    ->collapsible()
                    ->schema([
                        ComponentsGrid::make(3)->schema([
                            TextInput::make('zip_code')
                                ->label('CEP')
                                ->mask('99999-999')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $this->consultaCEP($state, $set);
                                })
                                ->helperText('Ao preencher, o endereço será buscado automaticamente'),

                            TextInput::make('street')
                                ->label('Logradouro')
                                ->columnSpan(2),
                        ]),

                        ComponentsGrid::make(4)->schema([
                            TextInput::make('number')
                                ->label('Número')
                                ->columnSpan(1),

                            TextInput::make('complement')
                                ->label('Complemento')
                                ->columnSpan(2),

                            TextInput::make('district')
                                ->label('Bairro')
                                ->columnSpan(1),
                        ]),

                        ComponentsGrid::make(4)->schema([
                            TextInput::make('city')
                                ->label('Cidade')
                                ->columnSpan(3),

                            Select::make('state')
                                ->label('UF')
                                ->options([
                                    'AC' => 'AC', 'AL' => 'AL', 'AP' => 'AP', 'AM' => 'AM',
                                    'BA' => 'BA', 'CE' => 'CE', 'DF' => 'DF', 'ES' => 'ES',
                                    'GO' => 'GO', 'MA' => 'MA', 'MT' => 'MT', 'MS' => 'MS',
                                    'MG' => 'MG', 'PA' => 'PA', 'PB' => 'PB', 'PR' => 'PR',
                                    'PE' => 'PE', 'PI' => 'PI', 'RJ' => 'RJ', 'RN' => 'RN',
                                    'RS' => 'RS', 'RO' => 'RO', 'RR' => 'RR', 'SC' => 'SC',
                                    'SP' => 'SP', 'SE' => 'SE', 'TO' => 'TO',
                                ])
                                ->searchable()
                                ->columnSpan(1),
                        ]),
                    ]),
            ]);
    }

    /**
     * Consulta CNPJ na BrasilAPI e preenche os campos
     */
    protected function consultaCNPJ(?string $cnpj, callable $set): void
    {
        if (!$cnpj) return;

        // Remove formatação
        $cnpj = preg_replace('/\D/', '', $cnpj);
        
        if (strlen($cnpj) !== 14) return;

        try {
            $response = Http::timeout(10)->get("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");

            if ($response->successful()) {
                $data = $response->json();

                $set('legal_name', $data['razao_social'] ?? '');
                $set('name', $data['nome_fantasia'] ?? $data['razao_social'] ?? '');
                $set('email', $data['email'] ?? '');
                $set('phone_1', $data['ddd_telefone_1'] ?? '');
                $set('zip_code', $data['cep'] ?? '');
                $set('street', $data['logradouro'] ?? '');
                $set('number', $data['numero'] ?? '');
                $set('complement', $data['complemento'] ?? '');
                $set('district', $data['bairro'] ?? '');
                $set('city', $data['municipio'] ?? '');
                $set('state', $data['uf'] ?? '');

                Notification::make()
                    ->title('CNPJ encontrado!')
                    ->body('Os dados foram preenchidos automaticamente.')
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('CNPJ não encontrado')
                    ->body('Verifique se o CNPJ está correto.')
                    ->warning()
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('Erro ao consultar CNPJ')
                ->body('Tente novamente mais tarde.')
                ->danger()
                ->send();
        }
    }

    /**
     * Consulta CEP no ViaCEP e preenche os campos de endereço
     */
    protected function consultaCEP(?string $cep, callable $set): void
    {
        if (!$cep) return;

        // Remove formatação
        $cep = preg_replace('/\D/', '', $cep);

        if (strlen($cep) !== 8) return;

        try {
            $response = Http::timeout(10)->get("https://viacep.com.br/ws/{$cep}/json/");

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['erro']) && $data['erro']) {
                    Notification::make()
                        ->title('CEP não encontrado')
                        ->body('Verifique se o CEP está correto.')
                        ->warning()
                        ->send();
                    return;
                }

                $set('street', $data['logradouro'] ?? '');
                $set('district', $data['bairro'] ?? '');
                $set('city', $data['localidade'] ?? '');
                $set('state', $data['uf'] ?? '');

                Notification::make()
                    ->title('CEP encontrado!')
                    ->body('O endereço foi preenchido automaticamente.')
                    ->success()
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('Erro ao consultar CEP')
                ->body('Tente novamente mais tarde.')
                ->danger()
                ->send();
        }
    }

    protected function getRedirectUrl(): ?string
    {
        // Redireciona para o novo subdomínio (caso o slug tenha mudado)
        $tenant = $this->tenant;
        $scheme = request()->secure() ? 'https' : 'http';
        $domain = config('app.domain');
        $port = request()->getPort();
        $portSuffix = in_array($port, [80, 443]) ? '' : ':' . $port;
        
        return "{$scheme}://{$tenant->slug}.{$domain}{$portSuffix}/";
    }

    /**
     * Intercepta os dados antes de salvar no banco.
     * Processa o upload da logo para o Cloudinary e atualiza o campo logo_url.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        \Illuminate\Support\Facades\Log::info('mutateFormDataBeforeSave INICIADO', ['data_keys' => array_keys($data)]);

        // Se houver arquivo de upload (array com caminho temporário)
        if (!empty($data['logo_upload'])) {
            \Illuminate\Support\Facades\Log::info('Logo upload detectado', ['value' => $data['logo_upload']]);
            
            $filename = is_array($data['logo_upload']) ? reset($data['logo_upload']) : $data['logo_upload'];
            
            // O caminho já vem com a pasta 'temp-uploads/' definida no componente, então removemos a duplicação aqui
            $filePath = storage_path('app/private/' . $filename);

            \Illuminate\Support\Facades\Log::info('Caminho do arquivo CORRIGIDO', ['path' => $filePath, 'exists' => file_exists($filePath)]);

            if (file_exists($filePath)) {
                try {
                    $cloudinaryService = app(CloudinaryService::class);
                    // Faz upload passando ID do tenant
                    $url = $cloudinaryService->uploadLogo($filePath, $this->tenant->id);
                    
                    \Illuminate\Support\Facades\Log::info('Upload sucesso', ['url' => $url]);

                    // Atualiza a URL no array de dados que será salvo
                    $data['logo_url'] = $url;
                    
                    Notification::make()
                        ->title('Logo atualizada!')
                        ->body('A nova imagem foi salva com sucesso.')
                        ->success()
                        ->send();
                        
                    // Remove arquivo temporário
                    @unlink($filePath);
                    
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Erro upload Cloudinary', ['msg' => $e->getMessage()]);

                    Notification::make()
                        ->title('Erro no upload')
                        ->body('Não foi possível enviar a imagem: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            }
        } else {
            \Illuminate\Support\Facades\Log::info('Nenhum logo_upload encontrado nos dados');
        }

        if (isset($data['logo_upload'])) {
            unset($data['logo_upload']);
        }

        \Illuminate\Support\Facades\Log::info('mutateFormDataBeforeSave RETORNANDO', ['logo_url' => $data['logo_url'] ?? 'NULL']);

        return $data;
    }
}
