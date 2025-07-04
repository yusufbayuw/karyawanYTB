<?php

namespace App\Observers;

use App\Models\CutiBesar;
use App\Models\GajiPegawai;
use App\Models\Pensiun;
use App\Models\Premi;

class GajiPegawaiObserver
{
    /**
     * Handle the GajiPegawai "created" event.
     */
    public function created(GajiPegawai $gajiPegawai): void
    {

        $user = $gajiPegawai->user;
        if ($user) {
            // hitung nominal di Premi sebesar setahun gaji pokok dikali persentase

            $premi = Premi::where('user_id', $user->id)
                ->whereYear('tanggal_premi', $gajiPegawai->tahun)
                ->first();
            if ($premi) {
                $gajiPokok = $gajiPegawai->nominal;
                $persentase = $premi->persentase / 100;
                $nominalPremi = $gajiPokok * $persentase * 12;
                $premi->update(['nominal' => $nominalPremi]);
            }
            // hitung cuti besar sebesar 1/2 gaji pokok
            $cutiBesar = CutiBesar::where('user_id', $user->id)
                ->whereYear('tanggal_pengajuan', $gajiPegawai->tahun)
                ->first();
            if ($cutiBesar) {
                $nominalCutiBesar = $gajiPegawai->nominal / 2;
                $cutiBesar->update(['nominal_kompensasi' => $nominalCutiBesar]);
            }
            // hitung uang pensiun sebesar 20 kali dari gaji pokok
            $uangPensiun = Pensiun::where('user_id', $user->id)
                ->whereYear('tanggal_pensiun', $gajiPegawai->tahun)
                ->first();
            if ($uangPensiun) {
                $nominalUangPensiun = $gajiPegawai->nominal * 20;
                $uangPensiun->update(['nominal' => $nominalUangPensiun]);
            }
        }
    }

    /**
     * Handle the GajiPegawai "updated" event.
     */
    public function updated(GajiPegawai $gajiPegawai): void
    {
        $user = $gajiPegawai->user;
        if ($user) {
            // hitung nominal di Premi sebesar setahun gaji pokok dikali persentase
            if ($gajiPegawai->isDirty('tahun')) {
                // jika tahun berubah, reset premi, cuti besar, dan uang pensiun sebelumnya
                $premiSebelumnya = Premi::where('user_id', $user->id)
                    ->whereYear('tanggal_premi', $gajiPegawai->getOriginal('tahun'))
                    ->first();
                if ($premiSebelumnya) {
                    $premiSebelumnya->update(['nominal' => null]);
                }
            }
            $premi = Premi::where('user_id', $user->id)
                ->whereYear('tanggal_premi', $gajiPegawai->tahun)
                ->first();
            // jika premi tidak ada, buat baru
            if ($premi) {
                $gajiPokok = $gajiPegawai->nominal;
                $persentase = $premi->persentase / 100;
                $nominalPremi = $gajiPokok * $persentase * 12;
                $premi->update(['nominal' => $nominalPremi]);
            }
            // hitung cuti besar sebesar 1/2 gaji pokok
            if ($gajiPegawai->isDirty('tahun')) {
                // jika tahun berubah, reset cuti besar sebelumnya
                // jika cuti besar sebelumnya ada, reset nominal kompensasi
                $cutiBesarSebelumnya = CutiBesar::where('user_id', $user->id)
                    ->whereYear('tanggal_pengajuan', $gajiPegawai->getOriginal('tahun'))
                    ->first();
                if ($cutiBesarSebelumnya) {
                    $cutiBesarSebelumnya->update(['nominal_kompensasi' => null]);
                }
            }
            // jika cuti besar tidak ada, buat baru
            $cutiBesar = CutiBesar::where('user_id', $user->id)
                ->whereYear('tanggal_pengajuan', $gajiPegawai->tahun)
                ->first();
            if ($cutiBesar) {
                $nominalCutiBesar = $gajiPegawai->nominal / 2;
                $cutiBesar->update(['nominal_kompensasi' => $nominalCutiBesar]);
            }
            // hitung uang pensiun sebesar 20 kali dari gaji pokok
            if ($gajiPegawai->isDirty('tahun')) {
                // jika tahun berubah, reset uang pensiun sebelumnya
                // jika uang pensiun sebelumnya ada, reset nominal
                // jika uang pensiun tidak ada, buat baru
                $uangPensiunSebelumnya = Pensiun::where('user_id', $user->id)
                    ->whereYear('tanggal_pensiun', $gajiPegawai->getOriginal('tahun'))
                    ->first();
                if ($uangPensiunSebelumnya) {
                    $uangPensiunSebelumnya->update(['nominal' => null]);
                }
            }
            $uangPensiun = Pensiun::where('user_id', $user->id)
                ->whereYear('tanggal_pensiun', $gajiPegawai->tahun)
                ->first();
            if ($uangPensiun) {
                $nominalUangPensiun = $gajiPegawai->nominal * 20;
                $uangPensiun->update(['nominal' => $nominalUangPensiun]);
            }
        }
    }

    /**
     * Handle the GajiPegawai "deleted" event.
     */
    public function deleted(GajiPegawai $gajiPegawai): void
    {
        //
    }

    /**
     * Handle the GajiPegawai "restored" event.
     */
    public function restored(GajiPegawai $gajiPegawai): void
    {
        //
    }

    /**
     * Handle the GajiPegawai "force deleted" event.
     */
    public function forceDeleted(GajiPegawai $gajiPegawai): void
    {
        //
    }
}
