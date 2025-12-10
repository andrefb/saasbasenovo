<?php

namespace App\Filament\App\Resources\Developments\Schemas;

use App\Models\Development;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DevelopmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificação')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome Fantasia'),
                        TextEntry::make('slug')
                            ->label('Slug'),
                        TextEntry::make('legal_name')
                            ->label('Razão Social')
                            ->placeholder('-'),
                        TextEntry::make('cnpj')
                            ->label('CNPJ')
                            ->placeholder('-'),
                        TextEntry::make('logo_url')
                            ->label('URL do Logo')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Endereço')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('zip_code')
                            ->label('CEP')
                            ->placeholder('-'),
                        TextEntry::make('street')
                            ->label('Logradouro')
                            ->placeholder('-'),
                        TextEntry::make('number')
                            ->label('Número')
                            ->placeholder('-'),
                        TextEntry::make('complement')
                            ->label('Complemento')
                            ->placeholder('-'),
                        TextEntry::make('district')
                            ->label('Bairro')
                            ->placeholder('-'),
                        TextEntry::make('city')
                            ->label('Cidade')
                            ->placeholder('-'),
                        TextEntry::make('state')
                            ->label('UF')
                            ->placeholder('-'),
                    ]),

                Section::make('Condições de Pagamento')
                    ->columns(4)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('down_payment_percent')
                            ->label('Entrada')
                            ->suffix('%')
                            ->placeholder('-'),
                        TextEntry::make('monthly_percent')
                            ->label('Mensais')
                            ->suffix('%')
                            ->placeholder('-'),
                        TextEntry::make('monthly_installments')
                            ->label('Qtd Mensais')
                            ->placeholder('-'),
                        TextEntry::make('annual_percent')
                            ->label('Anual')
                            ->suffix('%')
                            ->placeholder('-'),
                        TextEntry::make('annual_installments')
                            ->label('Qtd Anuais')
                            ->placeholder('-'),
                        TextEntry::make('keys_percent')
                            ->label('Chaves')
                            ->suffix('%')
                            ->placeholder('-'),
                        TextEntry::make('post_keys_percent')
                            ->label('Pós Chaves')
                            ->suffix('%')
                            ->placeholder('-'),
                        TextEntry::make('post_keys_installments')
                            ->label('Qtd Pós Chaves')
                            ->placeholder('-'),
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
                            ->visible(fn (Development $record): bool => $record->trashed()),
                    ]),
            ]);
    }
}
