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
            $table->boolean('is_jp')->default(false)->after('is_bulan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_p_i_kontraks', function (Blueprint $table) {
            $table->dropColumn('is_jp');
        });
    }
};
