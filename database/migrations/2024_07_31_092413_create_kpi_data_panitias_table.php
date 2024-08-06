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
        Schema::create('kpi_data_panitias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_kpi_id')->nullable()->constrained('k_p_i_periodes')->nullOnDelete();
            $table->foreignId('sk_id')->nullable()->constrained('kpi_sk_panitias')->nullOnDelete();
            $table->foreignId('kpi_kepanitiaan_id')->nullable()->constrained('kpi_kejuaraans')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_data_panitias');
    }
};
