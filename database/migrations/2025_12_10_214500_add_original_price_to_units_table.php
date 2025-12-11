<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->decimal('original_price', 12, 2)->nullable()->after('price');
        });

        // Copiar preço atual para original_price nas unidades existentes
        DB::table('units')->whereNull('original_price')->update([
            'original_price' => DB::raw('price')
        ]);
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('original_price');
        });
    }
};
