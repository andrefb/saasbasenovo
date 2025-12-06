<?php

namespace App\Filament\App\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Schema;

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

                        ComponentsGrid::make(2)->schema([
                            TextInput::make('cnpj')
                                ->mask('99.999.999/9999-99'),

                            TextInput::make('inscricao_estadual')
                                ->label('Inscrição Estadual'),
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
                                ->mask('99999-999'),

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
