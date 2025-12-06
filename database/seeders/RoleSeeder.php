<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Cria os roles padrão do sistema.
     * Pode rodar múltiplas vezes sem duplicar (usa firstOrCreate).
     */
    public function run(): void
    {
        $roles = [
            [
                'key' => 'owner',
                'name' => 'Dono',
                'description' => 'Proprietário da empresa com acesso total',
            ],
            [
                'key' => 'admin',
                'name' => 'Administrador',
                'description' => 'Acesso administrativo geral',
            ],
            [
                'key' => 'financial',
                'name' => 'Financeiro',
                'description' => 'Acesso ao módulo financeiro',
            ],
            [
                'key' => 'broker',
                'name' => 'Corretor',
                'description' => 'Corretor de imóveis',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['key' => $role['key']],
                $role
            );
        }

        $this->command->info('Roles criados/atualizados com sucesso!');
    }
}
