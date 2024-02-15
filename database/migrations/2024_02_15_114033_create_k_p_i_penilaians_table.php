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
        Schema::create('k_p_i_penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('kpi_kontrak_id')->nullable()->constrained('k_p_i_kontraks')->cascadeOnDelete();
            $table->foreignId('kpi_periode_id')->nullable()->constrained('k_p_i_periodes')->cascadeOnDelete();
            $table->decimal('realisasi')->nullable();
            $table->decimal('total_realisasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_p_i_penilaians');
    }
};
