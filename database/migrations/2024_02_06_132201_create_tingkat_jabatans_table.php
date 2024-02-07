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
        //harusnya golongans tapi nulisnya tingkat_jabatans :)
        Schema::create('tingkat_jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('golongan_id')->nullable()->constrained('golongans')->nullOnDelete();
            $table->treeColumns();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tingkat_jabatans');
    }
};
