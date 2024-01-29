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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('golongan_id')->nullable()->constrained('golongans')->nullOnDelete();
            $table->string('unsur');
            $table->string('sub_unsur');
            $table->string('uraian_1');
            $table->string('uraian_2');
            $table->string('uraian_3');
            $table->string('hasil_kerja');
            $table->decimal('angka_kredit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
