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
        Schema::table('k_p_i_penilaians', function (Blueprint $table) {
            //drop column
            $table->dropForeign(['kpi_periode_id']);
            $table->dropColumn('kpi_periode_id');
            //$table->dropColumn('realisasi');

            //add column
            $table->decimal('target')->nullable()->after('kpi_kontrak_id');
            $table->decimal('realisasi')->nullable()->change();
            $table->decimal('total')->nullable()->after('realisasi');
            $table->json('rincian_kepanitiaan')->nullable();
            $table->json('rincian_prestasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_p_i_penilaians', function (Blueprint $table) {
            // Remove the newly added columns
        $table->dropColumn('target');
        $table->dropColumn('realisasi');
        $table->dropColumn('total');
        $table->dropColumn('rincian_kepanitiaan');
        $table->dropColumn('rincian_prestasi');

        // Add back the dropped columns
        $table->unsignedBigInteger('kpi_periode_id')->after('id'); // adjust the position as needed
        $table->decimal('realisasi')->nullable()->after('id'); // adjust the position as needed

        // Add the foreign key constraint back
        $table->foreign('kpi_periode_id')->references('id')->on('k_p_i_periodes')->onDelete('cascade'); // adjust the onDelete action as needed
        });
    }
};
