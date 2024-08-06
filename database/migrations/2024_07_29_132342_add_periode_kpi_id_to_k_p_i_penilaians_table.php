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
        Schema::table('k_p_i_penilaians', function (Blueprint $table) {
            $table->foreignId('periode_kpi_id')->nullable()->constrained('k_p_i_periodes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_p_i_penilaians', function (Blueprint $table) {
            $table->dropForeign(['periode_kpi_id']);
            $table->dropColumn('periode_kpi_id');
        });
    }
};
