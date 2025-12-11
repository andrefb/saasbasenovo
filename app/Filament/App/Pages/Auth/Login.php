<?php

namespace App\Filament\App\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Schema;
use l3aro\FilamentTurnstile\Forms\Turnstile;

class Login extends BaseLogin
{
    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
                Turnstile::make('cf-turnstile')
                    ->theme('light')
                    ->size('normal'),
            ]);
    }
}
