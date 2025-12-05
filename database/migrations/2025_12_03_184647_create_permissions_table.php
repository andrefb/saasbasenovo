<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();

                $table->index('category');

            // Identificadores
            $table->string('key')->unique(); // Ex: 'users.create', 'reports.view'
            $table->string('name'); // Ex: 'Criar Usuários'

            // Organização visual no Painel
            $table->string('category'); // Ex: 'Usuários', 'Financeiro'
            $table->text('description')->nullable(); // Ex: 'Permite adicionar novos membros ao time'

            $table->timestamps();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
