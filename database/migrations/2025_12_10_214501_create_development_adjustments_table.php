<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('development_adjustments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('development_id')->constrained()->cascadeOnDelete();
            $table->decimal('adjustment_percent', 5, 2); // Ex: 0.50 para 0.5%
            $table->string('index_name', 50); // CUB, INCC, IPCA, Manual
            $table->text('notes')->nullable();
            $table->foreignUuid('applied_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('applied_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('development_adjustments');
    }
};
