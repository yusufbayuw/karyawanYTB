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
        Schema::create('kpi_sk_panitias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_kpi_id')->nullable()->constrained('k_p_i_periodes')->nullOnDelete();
            $table->string('nama')->nullable();
            $table->string('nomor')->nullable();
            $table->string('jenis')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_sk_panitias');
    }
};
