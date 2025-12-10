<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('developments', function (Blueprint $table) {
            // Condições de Pagamento - Percentuais
            $table->decimal('down_payment_percent', 5, 2)->nullable()->after('is_active');
            $table->decimal('monthly_percent', 5, 2)->nullable()->after('down_payment_percent');
            $table->integer('monthly_installments')->nullable()->after('monthly_percent');
            $table->decimal('annual_percent', 5, 2)->nullable()->after('monthly_installments');
            $table->integer('annual_installments')->nullable()->after('annual_percent');
            $table->decimal('keys_percent', 5, 2)->nullable()->after('annual_installments');
            $table->decimal('post_keys_percent', 5, 2)->nullable()->after('keys_percent');
            $table->integer('post_keys_installments')->nullable()->after('post_keys_percent');
        });
    }

    public function down(): void
    {
        Schema::table('developments', function (Blueprint $table) {
            $table->dropColumn([
                'down_payment_percent',
                'monthly_percent',
                'monthly_installments',
                'annual_percent',
                'annual_installments',
                'keys_percent',
                'post_keys_percent',
                'post_keys_installments',
            ]);
        });
    }
};
