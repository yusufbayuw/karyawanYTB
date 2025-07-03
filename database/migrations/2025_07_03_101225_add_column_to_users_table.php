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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tanggal_lahir')->nullable()->after('email');
            $table->string('nomor_sk_pegawai_tetap')->nullable()->after('tanggal_lahir');
            $table->string('tanggal_sk_pegawai_tetap')->nullable()->after('nomor_sk_pegawai_tetap');
            $table->string('berkas_sk_pegawai_tetap')->nullable()->after('tanggal_sk_pegawai_tetap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tanggal_lahir');
            $table->dropColumn('nomor_sk_pegawai_tetap');
            $table->dropColumn('tanggal_sk_pegawai_tetap');
            $table->dropColumn('berkas_sk_pegawai_tetap');
        });
    }
};
