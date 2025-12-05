<?php

namespace App\Filament\App\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    // Personaliza o formulário
    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                // Mantém os campos padrões (Nome e Email)
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),

                // Adiciona seus campos extras
                TextInput::make('phone')
                    ->label('Telefone')
                    ->tel(),

                TextInput::make('cpf')
                    ->label('CPF')
                    ->mask('999.999.999-99'),

                // Mantém o campo de senha
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
