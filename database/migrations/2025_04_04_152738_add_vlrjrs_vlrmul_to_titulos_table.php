<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('titulos', function (Blueprint $table) {
            $table->decimal('vlrJrs', 15, 2)->nullable()->after('vlrLiq');
            $table->decimal('vlrMul', 15, 2)->nullable()->after('vlrJrs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titulos', function (Blueprint $table) {
            $table->dropColumn(['vlrJrs', 'vlrMul']);
        });
    }
};
