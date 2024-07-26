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
        Schema::create('kpi_kejuaraans', function (Blueprint $table) {
            $table->id();
            $table->string('prestasi')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('kategori')->nullable();
            $table->decimal('poin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_kejuaraans');
    }
};
