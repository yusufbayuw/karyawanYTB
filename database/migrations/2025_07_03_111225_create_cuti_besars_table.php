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
        Schema::create('cuti_besars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_pengajuan')->nullable();
            $table->string('berkas_pengajuan')->nullable();
            $table->date('tanggal_realisasi_1')->nullable();
            $table->date('tanggal_realisasi_2')->nullable();
            $table->decimal('nominal_kompensasi', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti_besars');
    }
};
