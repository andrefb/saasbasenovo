<?php

namespace App\Filament\App\Resources\Developments\Tables;

use App\Models\Development;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class DevelopmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cnpj')
                    ->label('CNPJ')
                    ->searchable(),
                TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable(),
                TextColumn::make('state')
                    ->label('UF')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
                    ->label('Excluídos'),
            ])
            ->recordActions([
                Action::make('applyAdjustment')
                    ->label('Reajuste')
                    ->icon('heroicon-o-arrow-trending-up')
                    ->color('warning')
                    ->fillForm(fn (Development $record): array => [
                        'monthly_installments' => $record->monthly_installments,
                        'annual_installments' => $record->annual_installments,
                        'post_keys_installments' => $record->post_keys_installments,
                    ])
                    ->form([
                        Section::make('Reajuste de Preços')
                            ->description('Deixe em branco para não aplicar reajuste')
                            ->columns(2)
                            ->schema([
                                Select::make('index_name')
                                    ->label('Índice')
                                    ->options([
                                        'CUB' => 'CUB',
                                        'INCC' => 'INCC',
                                        'IPCA' => 'IPCA',
                                        'IGP-M' => 'IGP-M',
                                        'Manual' => 'Manual',
                                    ])
                                    ->placeholder('Selecione...'),
                                TextInput::make('adjustment_percent')
                                    ->label('Percentual (%)')
                                    ->numeric()
                                    ->step(0.01)
                                    ->suffix('%')
                                    ->helperText('Ex: 0.5 para 0,5%'),
                            ]),
                        Section::make('Quantidade de Parcelas')
                            ->columns(3)
                            ->schema([
                                TextInput::make('monthly_installments')
                                    ->label('Mensais')
                                    ->integer()
                                    ->minValue(0)
                                    ->suffix('x'),
                                TextInput::make('annual_installments')
                                    ->label('Anuais')
                                    ->integer()
                                    ->minValue(0)
                                    ->suffix('x'),
                                TextInput::make('post_keys_installments')
                                    ->label('Pós-Chaves')
                                    ->integer()
                                    ->minValue(0)
                                    ->suffix('x'),
                            ]),
                        Textarea::make('notes')
                            ->label('Observações')
                            ->rows(2),
                    ])
                    ->action(function (Development $record, array $data) {
                        $hasAdjustment = !empty($data['index_name']) && !empty($data['adjustment_percent']);
                        
                        // Atualizar quantidades de parcelas no empreendimento
                        $record->update([
                            'monthly_installments' => $data['monthly_installments'],
                            'annual_installments' => $data['annual_installments'],
                            'post_keys_installments' => $data['post_keys_installments'],
                        ]);

                        // Se tem reajuste de preço, aplicar
                        if ($hasAdjustment) {
                            $percent = (float) $data['adjustment_percent'];
                            $multiplier = 1 + ($percent / 100);

                            // Atualizar preços de todas as unidades
                            $record->units()->update([
                                'price' => DB::raw("price * {$multiplier}")
                            ]);

                            // Gravar histórico
                            $record->adjustments()->create([
                                'adjustment_percent' => $percent,
                                'index_name' => $data['index_name'],
                                'notes' => $data['notes'] ?? null,
                                'applied_by' => auth()->id(),
                                'applied_at' => now(),
                            ]);

                            Notification::make()
                                ->success()
                                ->title('Reajuste aplicado!')
                                ->body("Preços reajustados em {$percent}% e parcelas atualizadas")
                                ->send();
                        } else {
                            Notification::make()
                                ->success()
                                ->title('Parcelas atualizadas!')
                                ->body('Quantidades de parcelas foram salvas')
                                ->send();
                        }
                    })
                    ->modalHeading('Reajuste e Parcelas')
                    ->modalSubmitActionLabel('Salvar'),
                ViewAction::make()
                    ->label('Ver'),
                EditAction::make()
                    ->label('Editar'),
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
            ]);
    }
}
