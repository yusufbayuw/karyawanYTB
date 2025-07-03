<?php

namespace App\Observers;

use App\Models\CutiBesar;
use App\Models\Pensiun;
use App\Models\Premi;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        /* if ($user->unit_kpi_id) {
            $user->unit_id = $user->unit_kpi->unit->id;
            $user->saveQuietly();
        } */
        // buat tanggal pensiun otomatis ketika user dibuat
        if ($user->tanggal_lahir) {
            $tanggalPensiun = $user->tanggal_lahir->addYears($user->golongan->usia_pensiun ?? 60); // default 60 tahun jika tidak ada usia pensiun
            // update atau buat data pensiun untuk user
            Pensiun::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'tanggal_pensiun' => $tanggalPensiun,
                    //'nominal' => 0, // nilai default, bisa diubah sesuai kebutuhan
                ]
            );

            if ($user->tanggal_sk_pegawai_tetap) {
                // HITUNG PREMI OTOMATIS
                // loop tiap 5 tahun sejak tanggal SK Pegawai Tetap sampai tanggal pensiun
                // buat data premi setiap 5 tahun di tahun ke-5 sebesar 5%, 10 sebesar 10%, 15 dst sebesar 15%
                $tanggalMulai = $user->tanggal_sk_pegawai_tetap->copy();
                $tanggalAkhir = $tanggalPensiun;
                $tahunKe = 5;
                while ($tanggalMulai->addYears(5) <= $tanggalAkhir) {
                    $tanggalPremi = $user->tanggal_sk_pegawai_tetap->copy()->addYears($tahunKe);
                    // Premi: tahun ke-5 = 5%, ke-10 = 10%, ke-15 dst = 15%
                    if ($tahunKe == 5) {
                        $persen = 5;
                    } elseif ($tahunKe == 10) {
                        $persen = 10;
                    } else {
                        $persen = 15;
                    }
                    // Simpan premi
                    Premi::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'tanggal_premi' => $tanggalPremi,
                        ],
                        [

                            'persentase' => $persen,
                            'keterangan' => 'Premi tahun ke-' . $tahunKe,
                        ]
                    );
                    $tahunKe += 5;
                }

                // HITUNG CUTI BESAR OTOMATIS
                // loop tiap 6 tahun sejak tanggal SK Pegawai Tetap sampai tanggal pensiun
                // buat data cuti besar setiap 6 tahun di tahun ke-6, ke-12, ke-18 dst
                $tanggalMulaiCuti = $user->tanggal_sk_pegawai_tetap->copy();
                $tanggalAkhirCuti = $tanggalPensiun;
                $tahunKeCuti = 6;
                while ($tanggalMulaiCuti->addYears(6) <= $tanggalAkhirCuti) {
                    $tanggalCuti = $user->tanggal_sk_pegawai_tetap->copy()->addYears($tahunKeCuti);
                    // Simpan cuti besar
                    CutiBesar::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'tanggal_pengajuan' => $tanggalCuti,
                        ],
                        [
                            'tanggal_realisasi_1' => $tanggalCuti->copy()->addYear(), // realisasi 1 tahun setelah pengajuan
                            'tanggal_realisasi_2' => $tanggalCuti->copy()->addYears(2), // realisasi 2 tahun setelah pengajuan
                            'keterangan' => 'Cuti Besar tahun ke-' . $tahunKeCuti,
                        ]
                    );
                    $tahunKeCuti += 6;
                }
            }
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        /* if ($user->unit_kpi_id) {
            $user->unit_id = $user->unit_kpi->unit->id;
            $user->saveQuietly();
        } */

        if ($user->tanggal_lahir) {
            // ketika tanggal lahir diupdate, hitung ulang tanggal pensiun
            // gunakan if isDirty
            if ($user->isDirty('tanggal_lahir') || $user->isDirty('golongan_id')) {
                $tanggalPensiun = $user->tanggal_lahir->addYears($user->golongan->usia_pensiun ?? 60); // default 60 tahun jika tidak ada usia pensiun
                // update data pensiun untuk user
                Pensiun::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'tanggal_pensiun' => $tanggalPensiun,
                        //'nominal' => 0, // nilai default, bisa diubah sesuai kebutuhan
                    ]
                );

                if ($user->tanggal_sk_pegawai_tetap) {
                    // gunakan if isDirty untuk cek apakah tanggal SK Pegawai Tetap diupdate
                    if ($user->isDirty('tanggal_sk_pegawai_tetap')) {
                        // jika tanggal SK Pegawai Tetap diupdate, hapus semua data premi dan cut
                        Premi::where('user_id', $user->id)
                            ->delete();
                        // HITUNG PREMI OTOMATIS
                        // loop tiap 5 tahun sejak tanggal SK Pegawai Tetap sampai tanggal pensiun
                        // buat data premi setiap 5 tahun di tahun ke-5 sebesar 5%, 10 sebesar 10%, 15 dst sebesar 15%
                        $tanggalMulai = $user->tanggal_sk_pegawai_tetap->copy();
                        $tanggalAkhir = $tanggalPensiun;
                        $tahunKe = 5;
                        while ($tanggalMulai->addYears(5) <= $tanggalAkhir) {
                            $tanggalPremi = $user->tanggal_sk_pegawai_tetap->copy()->addYears($tahunKe);
                            // Premi: tahun ke-5 = 5%, ke-10 = 10%, ke-15 dst = 15%
                            if ($tahunKe == 5) {
                                $persen = 5;
                            } elseif ($tahunKe == 10) {
                                $persen = 10;
                            } else {
                                $persen = 15;
                            }
                            // Simpan premi
                            Premi::updateOrCreate(
                                [
                                    'user_id' => $user->id,
                                    'tanggal_premi' => $tanggalPremi,
                                ],
                                [

                                    'persentase' => $persen,
                                    'keterangan' => 'Premi tahun ke-' . $tahunKe,
                                ]
                            );
                            $tahunKe += 5;
                        }

                        CutiBesar::where('user_id', $user->id)
                            ->delete();
                        // HITUNG CUTI BESAR OTOMATIS
                        // loop tiap 6 tahun sejak tanggal SK Pegawai Tetap sampai tanggal pensiun
                        // buat data cuti besar setiap 6 tahun di tahun ke-6, ke-12, ke-18 dst
                        $tanggalMulaiCuti = $user->tanggal_sk_pegawai_tetap->copy();
                        $tanggalAkhirCuti = $tanggalPensiun;
                        $tahunKeCuti = 6;
                        while ($tanggalMulaiCuti->addYears(6) <= $tanggalAkhirCuti) {
                            $tanggalCuti = $user->tanggal_sk_pegawai_tetap->copy()->addYears($tahunKeCuti);
                            // Simpan cuti besar
                            CutiBesar::updateOrCreate(
                                [
                                    'user_id' => $user->id,
                                    'tanggal_pengajuan' => $tanggalCuti,
                                ],
                                [
                                    'tanggal_realisasi_1' => $tanggalCuti->copy()->addYear(), // realisasi 1 tahun setelah pengajuan
                                    'tanggal_realisasi_2' => $tanggalCuti->copy()->addYears(2), // realisasi 2 tahun setelah pengajuan
                                    'keterangan' => 'Cuti Besar tahun ke-' . $tahunKeCuti,
                                ]
                            );
                            $tahunKeCuti += 6;
                        }
                    }
                }
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
