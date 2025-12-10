<?php

namespace App\Filament\App\Resources\Units\Schemas;

use App\Models\Unit;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UnitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificação')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('development.name')
                            ->label('Empreendimento'),
                        TextEntry::make('number')
                            ->label('Número'),
                    ]),

                Section::make('Dados da Unidade')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('area')
                            ->label('Área')
                            ->numeric(decimalPlaces: 2)
                            ->suffix(' m²')
                            ->placeholder('-'),
                        TextEntry::make('price')
                            ->label('Valor')
                            ->money('BRL')
                            ->placeholder('-'),
                        TextEntry::make('floor_plan_url')
                            ->label('URL da Planta')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Status')
                    ->columns(2)
                    ->schema([
                        IconEntry::make('is_active')
                            ->label('Ativo')
                            ->boolean(),
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('deleted_at')
                            ->label('Excluído em')
                            ->dateTime('d/m/Y H:i')
                            ->visible(fn (Unit $record): bool => $record->trashed()),
                    ]),
            ]);
    }
}
