<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            // Dados do Perfil
            $table->string('name'); // Ex: 'Financeiro'
            $table->string('key')->unique(); // Ex: 'financial' (usado no código)
            $table->text('description')->nullable();

            // A Mágica Híbrida: Lista de keys de permissões
            // Ex: ["users.view", "invoices.*"]
            $table->json('default_permissions')->nullable();

            // Super Poderes
            $table->boolean('is_owner')->default(false); // Se true, tem acesso a TUDO (ignora permissões)

            // Proteção
            $table->boolean('is_system')->default(false); // Se true, não pode ser deletado via painel (Ex: Owner)

            // Ordenação visual (ex: Owner aparece primeiro)
            $table->integer('sort_order')->default(0);


            $table->index('is_system');  // Filtrar roles não-sistema
            $table->index('sort_order');  // Ordenação

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
