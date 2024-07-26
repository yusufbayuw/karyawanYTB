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
        Schema::table('k_p_i_kontraks', function (Blueprint $table) {
            // Drop existing columns
            $table->dropForeign(['kpi_flow_id']);
            $table->dropColumn('kpi_flow_id');
            $table->dropColumn('nama');
            $table->dropColumn('kuantitas');
            $table->dropColumn('keterangan_kuantitas');
            $table->dropColumn('total');
            $table->dropColumn('komponen_pengurang');

            // Add new columns
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans')->nullOnDelete();
            $table->foreignId('periode_kpi_id')->nullable()->constrained('k_p_i_periodes')->nullOnDelete();
            $table->string('order')->nullable();
            $table->string('kpi')->nullable();
            $table->string('currency')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('k_p_i_kontraks')->nullOnDelete();
            $table->boolean('is_kepanitiaan')->default(false);
            $table->boolean('is_kejuaraan')->default(false);
            $table->boolean('is_komponen_pengurang')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_p_i_kontraks', function (Blueprint $table) {
            // Drop new columns
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
            $table->dropForeign(['jabatan_id']);
            $table->dropColumn('jabatan_id');
            $table->dropForeign(['periode_kpi_id']);
            $table->dropColumn('periode_kpi_id');
            $table->dropColumn('order');
            $table->dropColumn('kpi');
            $table->dropColumn('currency');
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
            $table->dropColumn('is_kepanitiaan');
            $table->dropColumn('is_kejuaraan');
            $table->dropColumn('is_komponen_pengurang');

            // Add old columns back
            $table->foreignId('kpi_flow_id')->nullable()->constrained('k_p_i_flows')->nullOnDelete();
            $table->string('nama');
            $table->decimal('kuantitas')->nullable();
            $table->string('keterangan_kuantitas')->nullable();
            $table->decimal('total')->nullable();
            $table->boolean('komponen_pengurang')->default(false);
        });
    }
};
