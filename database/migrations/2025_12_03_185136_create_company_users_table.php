<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_user', function (Blueprint $table) {
            $table->id(); // ID próprio é útil para auditoria e logs

            $table->foreignUuid('company_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();

            // O cargo do usuário NESTA empresa
            $table->foreignId('role_id')->constrained();

            // Flag explícita de Dono (Facilita policies: "se é owner, pode tudo")
            $table->boolean('is_owner')->default(false);

            // Permissões customizadas JSON (conforme sua arquitetura híbrida)
            // Caso queira dar permissão extra além do Role
            $table->json('custom_permissions')->nullable();

            $table->timestamps();

            // Garante que o usuário não seja duplicado na mesma empresa
            $table->unique(['company_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_user');
    }
};
