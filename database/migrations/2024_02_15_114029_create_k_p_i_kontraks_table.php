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
        Schema::create('k_p_i_kontraks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_flow_id')->nullable()->constrained('k_p_i_flows')->nullOnDelete();
            $table->string('nama');
            $table->decimal('kuantitas')->nullable();
            $table->string('keterangan_kuantitas')->nullable();
            $table->decimal('total')->nullable();
            $table->boolean('komponen_pengurang')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_p_i_kontraks');
    }
};
