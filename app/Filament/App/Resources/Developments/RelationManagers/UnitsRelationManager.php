<?php

namespace App\Filament\App\Resources\Developments\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitsRelationManager extends RelationManager
{
    protected static string $relationship = 'units';

    protected static ?string $title = 'Unidades';
    protected static ?string $modelLabel = 'Unidade';
    protected static ?string $pluralModelLabel = 'Unidades';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Identificação')
                    ->columns(3)
                    ->schema([
                        TextInput::make('number')
                            ->label('Número')
                            ->helperText('Deve ser único neste empreendimento')
                            ->required()
                            ->maxLength(50)
                            ->unique(
                                table: 'units',
                                column: 'number',
                                ignoreRecord: true,
                                modifyRuleUsing: fn ($rule) => $rule->where('development_id', $this->getOwnerRecord()->id)
                            ),
                        TextInput::make('floor')
                            ->label('Andar')
                            ->helperText('Ex: 1, Térreo, A')
                            ->maxLength(20),
                        TextInput::make('position')
                            ->label('Posição')
                            ->helperText('Ex: 1, A, Frente')
                            ->maxLength(20),
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
                            ->label('Valor Total')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('R$'),
                        TextInput::make('floor_plan_url')
                            ->label('URL da Planta')
                            ->url()
                            ->columnSpanFull(),
                    ]),

                Section::make('Status')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Situação')
                            ->options([
                                'available' => 'Disponível',
                                'reserved' => 'Reservado',
                                'sold' => 'Vendido',
                            ])
                            ->default('available')
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Ativo no Sistema')
                            ->default(true),
                        Hidden::make('updated_by')
                            ->default(fn () => auth()->id()),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('number')
            ->defaultSort('number', 'asc')
            ->columns([
                // Identificação
                TextColumn::make('number')
                    ->label('Unidade')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('floor')
                    ->label('Andar')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Preço Total')
                    ->money('BRL')
                    ->sortable()
                    ->alignEnd()
                    ->weight('bold'),
                
                // ENTRADA
                TextColumn::make('down_payment_value')
                    ->label('Entrada')
                    ->money('BRL')
                    ->alignEnd(),
                
                // MENSAIS
                TextColumn::make('development.monthly_percent')
                    ->label('Mensais %')
                    ->suffix('%')
                    ->alignEnd(),
                TextColumn::make('monthly_value')
                    ->label('Mensais Total')
                    ->money('BRL')
                    ->alignEnd(),
                TextColumn::make('development.monthly_installments')
                    ->label('Qtd')
                    ->suffix('x')
                    ->alignEnd(),
                TextColumn::make('monthly_installment_value')
                    ->label('Parcela')
                    ->money('BRL')
                    ->alignEnd(),
                
                // ANUAL (toggleable)
                TextColumn::make('development.annual_percent')
                    ->label('Anual %')
                    ->suffix('%')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('annual_value')
                    ->label('Anual Total')
                    ->money('BRL')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('development.annual_installments')
                    ->label('Qtd Anual')
                    ->suffix('x')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('annual_installment_value')
                    ->label('Parcela Anual')
                    ->money('BRL')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                // CHAVES (toggleable)
                TextColumn::make('keys_value')
                    ->label('Chaves')
                    ->money('BRL')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                // PÓS-CHAVES (toggleable)
                TextColumn::make('development.post_keys_percent')
                    ->label('Pós %')
                    ->suffix('%')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('post_keys_value')
                    ->label('Pós Total')
                    ->money('BRL')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('development.post_keys_installments')
                    ->label('Qtd Pós')
                    ->suffix('x')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('post_keys_installment_value')
                    ->label('Parcela Pós')
                    ->money('BRL')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                // STATUS
                TextColumn::make('status')
                    ->label('Situação')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'reserved' => 'warning',
                        'sold' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Disponível',
                        'reserved' => 'Reservado',
                        'sold' => 'Vendido',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Situação')
                    ->options([
                        'available' => 'Disponível',
                        'reserved' => 'Reservado',
                        'sold' => 'Vendido',
                    ]),
                TrashedFilter::make()
                    ->label('Excluídos'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nova Unidade'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Editar'),
                DeleteAction::make()
                    ->label('Excluir'),
                RestoreAction::make()
                    ->label('Restaurar'),
                ForceDeleteAction::make()
                    ->label('Excluir Permanente'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Excluir'),
                    ForceDeleteBulkAction::make()
                        ->label('Excluir permanentemente'),
                    RestoreBulkAction::make()
                        ->label('Restaurar'),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
