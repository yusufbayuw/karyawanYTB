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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('parameter_id')->nullable()->constrained('parameters')->cascadeOnDelete();
            $table->foreignId('periode_id')->nullable()->constrained('periodes')->cascadeOnDelete();
            $table->decimal('nilai')->nullable();
            $table->string('file')->nullable();
            $table->boolean('approval')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
