<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('floor', 20)->nullable()->after('number'); // Andar (pode ser "1", "Térreo", "A", etc)
            $table->string('position', 20)->nullable()->after('floor'); // Posição (pode ser "1", "A", "Frente", etc)
            $table->string('status', 20)->default('available')->after('position'); // available, reserved, sold
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn(['floor', 'position', 'status']);
        });
    }
};
