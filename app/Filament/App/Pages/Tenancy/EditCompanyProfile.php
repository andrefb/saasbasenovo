<?php

namespace App\Filament\App\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
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

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nome')->required(),
                TextInput::make('slug')->label('URL')->required()->unique('companies', 'slug', ignoreRecord: true),

                ComponentsGrid::make(2)->schema([
                    TextInput::make('cnpj')->mask('99.999.999/9999-99'),
                    TextInput::make('email')->email(),
                    TextInput::make('phone_1')->label('Telefone'),
                ]),
            ]);
    }
}
