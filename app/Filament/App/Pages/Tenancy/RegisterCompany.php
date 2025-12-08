<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Models\Company;
use App\Models\Role;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RegisterCompany extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Nova Empresa';
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome da Empresa')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label('URL (Slug)')
                    ->required()
                    ->prefix('/app/')
                    ->helperText('Sua empresa ficará acessível em: /app/seu-slug')
                    ->unique(Company::class, 'slug')
                    ->validationMessages([
                        'unique' => 'Este endereço já está sendo usado por outra empresa.',
                    ]),
            ]);
    }

    protected function handleRegistration(array $data): Company
    {
        $company = Company::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'is_active' => true,
            'trial_ends_at' => now()->addDays(15),
        ]);

        // Pega o Role de Owner (Dono)
        $ownerRole = Role::where('key', 'owner')->first();

        // Vincula o usuário atual
        $company->users()->attach(auth()->user(), [
            'role_id' => $ownerRole->id,
            'is_owner' => true,
        ]);

        return $company;
    }
}
