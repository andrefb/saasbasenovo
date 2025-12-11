<?php

namespace App\Filament\App\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Schemas\Schema;
use l3aro\FilamentTurnstile\Forms\Turnstile;

class Register extends BaseRegister
{
    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                Turnstile::make('cf-turnstile')
                    ->theme('light')
                    ->size('normal'),
            ]);
    }
}
