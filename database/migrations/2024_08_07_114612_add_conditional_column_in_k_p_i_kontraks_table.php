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
            $table->boolean('is_persentase')->default(false)->after('is_komponen_pengurang');
            $table->boolean('is_pengali')->default(false)->after('is_persentase');
            $table->boolean('is_static')->default(false)->after('is_pengali');
            $table->boolean('is_bulan')->default(false)->after('is_static');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_p_i_kontraks', function (Blueprint $table) {
            $table->dropColumn('is_persentase');
            $table->dropColumn('is_pengali');
            $table->dropColumn('is_static');
            $table->dropColumn('is_bulan');
        });
    }
};
