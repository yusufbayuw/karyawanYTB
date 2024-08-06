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
        Schema::table('k_p_i_kontraks', function (Blueprint $table) {
            $table->foreignId('unit_kpi_id')->nullable()->constrained('unit_kpis')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_p_i_kontraks', function (Blueprint $table) {
            $table->dropForeign(['unit_kpi_id']);
            $table->dropColumn('unit_kpi_id');
        });
    }
};
