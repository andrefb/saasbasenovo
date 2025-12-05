<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Identificação Básica
            $table->string('name'); // Nome Fantasia (usado nos menus/slugs)
            $table->string('slug')->unique(); // Para URL: app.dominio.com/slug-da-empresa
            $table->string('legal_name')->nullable(); // Razão Social
            $table->string('cnpj', 20)->nullable()->unique();
            $table->string('inscricao_estadual')->nullable(); // Inscrição Estadual

            // Contato
            $table->string('email')->nullable(); // Email da empresa (geral)
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('website')->nullable();

            // Endereço
            $table->string('zip_code', 10)->nullable(); // CEP
            $table->string('street')->nullable(); // Logradouro
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('district')->nullable(); // Bairro
            $table->string('city')->nullable();
            $table->char('state', 2)->nullable(); // UF

            // Controle do SaaS
            $table->boolean('is_active')->default(true); // Bloqueio administrativo
            $table->timestamp('trial_ends_at')->nullable(); // Trial de 15 dias

            // Auditoria
           $table->uuid('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
