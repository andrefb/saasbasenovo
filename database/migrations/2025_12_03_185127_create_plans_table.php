<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            // Identificação
            $table->string('name'); // Ex: "Básico", "Pro", "Enterprise"
            $table->text('description')->nullable();
            $table->string('slug')->unique(); // Ex: "basic-monthly"

            // Preço e Ciclo
            $table->integer('price'); // Em centavos! (Ex: 2990 = R$ 29,90)
            $table->string('currency', 3)->default('BRL');
            $table->string('interval')->default('month'); // 'month' ou 'year'
            $table->integer('interval_count')->default(1); // 1 mês, 3 meses, 1 ano...
$table->integer('trial_days')->default(0);
            // Limites e Funcionalidades (O Coração do SaaS)
            // Ex: {"max_users": 5, "max_projects": 10, "can_export": true}
            $table->json('features')->nullable();

            // Integração (Futuro)
            $table->string('gateway_id')->nullable(); // ID do plano no Stripe/Asaas

            // Controle
            $table->boolean('is_active')->default(true); // Se false, não aparece para novos users
            $table->integer('sort_order')->default(0); // Ordem na tela de preços


$table->index('is_active');
$table->index('sort_order');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
