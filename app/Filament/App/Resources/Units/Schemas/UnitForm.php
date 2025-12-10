<?php

namespace App\Filament\App\Resources\Units\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificação')
                    ->columns(2)
                    ->schema([
                        Select::make('development_id')
                            ->label('Empreendimento')
                            ->relationship('development', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('number')
                            ->label('Número/Identificação')
                            ->helperText('Ex: 101, 101A, Bloco B')
                            ->required()
                            ->maxLength(50),
                    ]),

                Section::make('Dados da Unidade')
                    ->columns(2)
                    ->schema([
                        TextInput::make('area')
                            ->label('Área (m²)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('m²'),
                        TextInput::make('price')
                            ->label('Valor')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('R$'),
                        TextInput::make('floor_plan_url')
                            ->label('URL da Planta')
                            ->url()
                            ->columnSpanFull(),
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
