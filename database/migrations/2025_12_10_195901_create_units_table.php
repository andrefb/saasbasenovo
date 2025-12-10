<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Relacionamento com Development
            $table->foreignUuid('development_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Identificação
            $table->string('number'); // Número/identificação (pode ter letras: "101A", "Bloco B")
            
            // Dados da unidade
            $table->decimal('area', 10, 2)->nullable(); // Área em m²
            $table->decimal('price', 15, 2)->nullable(); // Valor em R$
            $table->string('floor_plan_url')->nullable(); // URL da planta

            // Controle
            $table->boolean('is_active')->default(true);

            // Auditoria
            $table->uuid('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índice único composto: número único por empreendimento
            $table->unique(['development_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
