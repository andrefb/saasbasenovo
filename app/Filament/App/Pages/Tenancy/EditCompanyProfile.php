<?php

namespace App\Filament\App\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
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
                                ->url()
                                ->prefix('https://'),
                        ]),

                        ComponentsGrid::make(2)->schema([
                            TextInput::make('phone_1')
                                ->label('Telefone 1')
                                ->tel(),

                            TextInput::make('phone_2')
                                ->label('Telefone 2')
                                ->tel(),
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
                                ->label('Número'),

                            TextInput::make('complement')
                                ->label('Complemento'),

                            TextInput::make('district')
                                ->label('Bairro'),

                            TextInput::make('city')
                                ->label('Cidade'),
                        ]),

                        TextInput::make('state')
                            ->label('UF')
                            ->maxLength(2)
                            ->extraInputAttributes(['style' => 'text-transform: uppercase'])
                            ->dehydrateStateUsing(fn ($state) => strtoupper($state)),
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
}
