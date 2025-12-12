<?php

namespace App\Filament\App\Resources\Developments\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DevelopmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificação')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Fantasia')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, $get) => 
                                $get('slug') ? null : $set('slug', Str::slug($state))
                            ),
                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->alphaDash(),
                        TextInput::make('legal_name')
                            ->label('Razão Social')
                            ->maxLength(255),
                        TextInput::make('cnpj')
                            ->label('CNPJ')
                            ->mask('99.999.999/9999-99')
                            ->maxLength(20),
                        TextInput::make('logo_url')
                            ->label('URL do Logo Atual')
                            ->readOnly()
                            ->helperText('URL no Cloudinary (gerada ao salvar)')
                            ->columnSpanFull(),
                        FileUpload::make('logo_upload')
                            ->label('Enviar Nova Logo')
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->disk('local')
                            ->directory('temp-uploads')
                            ->visibility('private')
                            ->helperText('Formatos: JPG, PNG, WebP, SVG. Máximo: 2MB. Clique em Salvar para enviar.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Endereço')
                    ->columns(2)
                    ->schema([
                        TextInput::make('zip_code')
                            ->label('CEP')
                            ->mask('99999-999')
                            ->maxLength(10),
                        TextInput::make('street')
                            ->label('Logradouro')
                            ->maxLength(255),
                        TextInput::make('number')
                            ->label('Número')
                            ->maxLength(20),
                        TextInput::make('complement')
                            ->label('Complemento')
                            ->maxLength(255),
                        TextInput::make('district')
                            ->label('Bairro')
                            ->maxLength(255),
                        TextInput::make('city')
                            ->label('Cidade')
                            ->maxLength(255),
                        TextInput::make('state')
                            ->label('UF')
                            ->maxLength(2),
                    ]),

                Section::make('Condições de Pagamento')
                    ->columns(3)
                    ->collapsible()
                    ->schema([
                        TextInput::make('down_payment_percent')
                            ->label('Entrada')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('monthly_percent')
                            ->label('Mensais (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('monthly_installments')
                            ->label('Qtd Mensais')
                            ->integer()
                            ->minValue(1),
                        TextInput::make('annual_percent')
                            ->label('Anual (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('annual_installments')
                            ->label('Qtd Anuais')
                            ->integer()
                            ->minValue(1),
                        TextInput::make('keys_percent')
                            ->label('Chaves')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('post_keys_percent')
                            ->label('Pós Chaves (%)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('post_keys_installments')
                            ->label('Qtd Pós Chaves')
                            ->integer()
                            ->minValue(1),
                    ]),

                Section::make('Configurações')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ]),
            ]);
    }
}
