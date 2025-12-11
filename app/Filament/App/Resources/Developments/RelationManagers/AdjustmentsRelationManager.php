<?php

namespace App\Filament\App\Resources\Developments\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdjustmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'adjustments';

    protected static ?string $title = 'Histórico de Reajustes';
    protected static ?string $modelLabel = 'Reajuste';
    protected static ?string $pluralModelLabel = 'Reajustes';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('index_name')
            ->columns([
                TextColumn::make('applied_at')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('index_name')
                    ->label('Índice')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('adjustment_percent')
                    ->label('Reajuste')
                    ->formatStateUsing(fn ($state) => ($state >= 0 ? '+' : '') . number_format($state, 2, ',', '.') . '%')
                    ->color(fn ($state) => $state >= 0 ? 'success' : 'danger')
                    ->weight('bold'),
                TextColumn::make('appliedByUser.name')
                    ->label('Aplicado por'),
                TextColumn::make('notes')
                    ->label('Observações')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('applied_at', 'desc')
            ->paginated(false);
    }
}
