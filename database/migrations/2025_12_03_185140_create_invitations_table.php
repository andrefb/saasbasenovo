<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->index('email');
            // Quem está convidando e para onde?
            $table->foreignUuid('company_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('inviter_id')->constrained('users')->nullOnDelete(); // Quem enviou o convite

            // Quem está sendo convidado e qual será o papel?
            $table->string('email');
            // Como a tabela roles ainda não foi criada no banco nesse momento do script,
            // usamos bigInteger em vez de constrained imediato, ou garantimos a ordem.
            // Vou assumir constrained assumindo que role será criada antes.
            $table->foreignId('role_id')->constrained();

            // Controle do Convite
            $table->string('token', 64)->unique();
            $table->timestamp('expires_at');

            $table->timestamp('accepted_at')->nullable();

            // APENAS INDEXES (SEM unique):
            $table->index(['email', 'company_id']);
            $table->index('expires_at');

            $table->timestamps();
        // Permite mesmo email+company se accepted_at != null
            // SoftDeletes aqui é opcional. Se deletar um convite pendente,
            // geralmente queremos que o link pare de funcionar imediatamente.
            // Vou deixar SEM softDeletes para convites pendentes (cancelamento real),
            // mas o registro aceito fica pra sempre por causa do accepted_at.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
