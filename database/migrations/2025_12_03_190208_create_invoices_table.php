<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('invoices', function (Blueprint $table) {
    $table->id();

    // De quem é essa conta?
    $table->foreignUuid('company_id')->constrained()->cascadeOnDelete();

    // Refere-se a qual assinatura?
    $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();

    // Valores
    $table->integer('amount'); // Centavos
    $table->string('currency', 3)->default('BRL');

    // Status e Gateway
    $table->string('status'); // paid, open, void, uncollectible
    $table->string('gateway_id')->nullable();
    $table->string('gateway_pdf_url')->nullable(); // ← Renomeado

    // Datas
    $table->timestamp('due_date')->nullable();
    $table->timestamp('paid_at')->nullable();

    // Metadata extra
    $table->json('metadata')->nullable(); // ← Adicionado

    // Indexes
    $table->index('status');
    $table->index('due_date');
    $table->index(['company_id', 'status']);

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
