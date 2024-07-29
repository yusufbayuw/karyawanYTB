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
        Schema::table('unit_kpis', function (Blueprint $table) {
            $table->renameColumn('kode', 'code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_kpis', function (Blueprint $table) {
            $table->renameColumn('code', 'kode');
        });
    }
};
