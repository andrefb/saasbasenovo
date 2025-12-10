<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Relacionamento com Company
            $table->foreignUuid('company_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Identificação Básica
            $table->string('name'); // Nome Fantasia
            $table->string('slug'); // Slug único por empresa
            $table->string('legal_name')->nullable(); // Razão Social
            $table->string('cnpj', 20)->nullable();
            $table->string('logo_url')->nullable();

            // Endereço
            $table->string('zip_code', 10)->nullable(); // CEP
            $table->string('street')->nullable(); // Logradouro
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('district')->nullable(); // Bairro
            $table->string('city')->nullable();
            $table->char('state', 2)->nullable(); // UF

            // Controle
            $table->boolean('is_active')->default(true);

            // Auditoria
            $table->uuid('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índice único composto: slug único por empresa
            $table->unique(['company_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developments');
    }
};
