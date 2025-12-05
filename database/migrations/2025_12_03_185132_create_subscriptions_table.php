<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            // Quem assina?
            $table->foreignUuid('company_id')->constrained()->cascadeOnDelete();

            // O que assina?
            $table->foreignId('plan_id')->constrained();

            // Estado da Assinatura
            $table->string('status'); // active, past_due, canceled, incomplete, trialing

            // Referência Externa (Stripe/Asaas)
            $table->string('gateway_id')->nullable(); // ID da assinatura no gateway

            $table->json('metadata')->nullable();

            // Ciclo de Vida
            $table->timestamp('trial_ends_at')->nullable(); // Se tiver trial específico da assinatura
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable(); // Quando finaliza de vez
            $table->timestamp('canceled_at')->nullable(); // Quando usuário clicou em cancelar

            // Controle de Renovação
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable(); // Data chave para bloquear acesso

            $table->index('status');
$table->index('current_period_end');
$table->index(['company_id', 'status']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
