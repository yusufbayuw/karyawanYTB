<?php

namespace App\Observers;

use App\Models\User;
use App\Models\KPIPenilaian;
use Illuminate\Support\Facades\DB;

class KPIPenilaianObserver
{
    /**
     * Handle the KPIPenilaian "created" event.
     */
    public function created(KPIPenilaian $kPIPenilaian): void
    {
        //
    }

    /**
     * Handle the KPIPenilaian "updated" event.
     */
    public function updated(KPIPenilaian $kPIPenilaian): void
    {
        $kontrak = $kPIPenilaian->kontrak;
        if ($kontrak->is_komponen_pengurang) { // case pengurang total
            if ($kontrak->kpi === "Persentase kepatuhan organisasi terhadap hukum dan peraturan perundangan yang berlaku") {
                $sumAll = KPIPenilaian::where('periode_kpi_id', $kPIPenilaian->periode_kpi_id)
                    ->where('user_id', $kPIPenilaian->user_id)
                    ->whereHas('kontrak', function ($query) use ($kPIPenilaian) {
                        $query->where('job_code', $kPIPenilaian->kontrak->job_code)->where('is_komponen_pengurang', false);
                    })->sum('total_realisasi');

                $kPIPenilaian->total_realisasi = (-1) * ((100 - $kPIPenilaian->realisasi) / 100) * $sumAll / 2;
                $kPIPenilaian->saveQuietly();
            } elseif ($kontrak->kpi = "Persentase keluhan terhadap layanan yang diberikan") {
                $sumAll = KPIPenilaian::where('periode_kpi_id', $kPIPenilaian->periode_kpi_id)
                    ->where('user_id', $kPIPenilaian->user_id)
                    ->whereHas('kontrak', function ($query) use ($kPIPenilaian) {
                        $query->where('job_code', $kPIPenilaian->kontrak->job_code)->where('is_komponen_pengurang', false);
                    })->sum('total_realisasi');

                $kPIPenilaian->total_realisasi = (-1) * ($kPIPenilaian->realisasi / 100) * $sumAll / 2;
                $kPIPenilaian->saveQuietly();
            }
        } else {
            if ($kontrak->is_kepanitiaan) { // case kepanitiaan
                # code...
            } elseif ($kontrak->is_kejuaraan) { // case kejuaraan
                # code...
            } elseif ($kontrak->is_cabang_pengurang) { // case cabang pengurang
                $poin_induk = KPIPenilaian::where('periode_kpi_id', $kPIPenilaian->periode_kpi_id)
                    ->where('user_id', $kPIPenilaian->user_id)
                    ->whereHas('kontrak', function ($query) use ($kPIPenilaian) {
                        $query->where('code', substr($kPIPenilaian->kontrak->code, 0, -1));
                    })->first();
                if ($poin_induk->total_realisasi) {
                    $kPIPenilaian->total_realisasi = ($poin_induk->total_realisasi * $kPIPenilaian->realisasi / 100) - $poin_induk->total_realisasi;
                    $kPIPenilaian->saveQuietly();
                }
            } elseif ($kontrak->terusan) {
                // menelusuri terusan ke mana saja
                $atasan_jabatan = $kPIPenilaian->user->jabatan->parent ?? 0;
                /// apakah atasan exist atau tidak, trigger jika iya
                if ($atasan_jabatan) {
                    if ($kontrak->is_persentase) { // kasus perhitungan dengan persentase
                        $kPIPenilaian->total_realisasi = $kPIPenilaian->total > 0 ? (float)$kPIPenilaian->realisasi / (float)$kPIPenilaian->target * (float)$kontrak->poin : 0;
                        $kPIPenilaian->saveQuietly();
                    } elseif ($kontrak->is_pengali) { // kasus perhitungan dengan pengali
                        $kPIPenilaian->total_realisasi = $kPIPenilaian->total > 0 ? (float)$kPIPenilaian->realisasi * (float)$kontrak->poin : 0;
                        $kPIPenilaian->saveQuietly();
                    } elseif ($kontrak->is_static) { // kasus perhitungan dengan static => realisasi = total_realisasi
                        $kPIPenilaian->total_realisasi = $kPIPenilaian->realisasi;
                        $kPIPenilaian->saveQuietly();
                    } elseif ($kontrak->is_bulan) { // kasus perhitungan bulan => pada asm dan stimb
                        $kPIPenilaian->total_realisasi = (float)$kPIPenilaian->poin * (((float)$kPIPenilaian->target - (float)$kPIPenilaian->realisasi) * ((float)$kPIPenilaian->poin / (float)$kPIPenilaian->target));
                        $kPIPenilaian->saveQuietly();
                    } elseif ($kontrak->is_jp) { // kasus perhitungan jam pelajaran pada unit tk, sd, smp, sma
                        $kPIPenilaian->total_realisasi = ((float)$kPIPenilaian->realisasi * (float)$kontrak->poin) - (0 * (float)$kontrak->poin);
                        $kPIPenilaian->saveQuietly();
                    }
                    /// apakah kontrak berelasi ke atasan, trigger jika iya
                    $terusans = $kontrak->terusan;
                    
                    if ($terusans) {
                        // looping semua terusan
                        foreach ($terusans as $terusan) {
                            $terusan_id = $terusan['kontrak'] ?? 0; //mencari terusan relasi kontrak
                            // jika terusan relasi ada
                            if ($terusan_id) {
                                $atasans = User::where('jabatan_id', $atasan_jabatan->id)->get() ?? null;
                                
                                if ($atasans) {
                                    foreach ($atasans as $atasan) {
                                        /// hitung rata-rata dari bawahan
                                        // penilaian KPI atasan
                                        $penilaians = KPIPenilaian::where('periode_kpi_id', $kPIPenilaian->periode_kpi_id)
                                            ->where('kpi_kontrak_id', $terusan_id)
                                            ->where('user_id', $atasan->id)
                                            ->get();
                                        //dd($penilaians);
                                        //untuk tiap penilaian atasan
                                        foreach ($penilaians as $penilaian) {
                                            $penilaian->realisasi = KPIPenilaian::where('periode_kpi_id', $kPIPenilaian->periode_kpi_id)
                                                ->where('kpi_kontrak_id', $kontrak->id)
                                                ->where('user_id', '!=', $penilaian->user_id)
                                                ->avg('realisasi');
                                            //dd($penilaian->realisasi);
                                            if ($penilaian->kontrak->is_persentase) { // kasus perhitungan dengan persentase
                                                $penilaian->total_realisasi = $penilaian->total > 0 ? (float)$penilaian->realisasi / (float)$penilaian->target * (float)$penilaian->kontrak->poin : 0;
                                                $penilaian->save();
                                            } elseif ($penilaian->kontrak->is_pengali) { // kasus perhitungan dengan pengali
                                                $penilaian->total_realisasi = $penilaian->total > 0 ? (float)$penilaian->realisasi * (float)$penilaian->kontrak->poin : 0;
                                                $penilaian->save();
                                            } elseif ($penilaian->kontrak->is_static) { // kasus perhitungan dengan static => realisasi = total_realisasi
                                                $penilaian->total_realisasi = $penilaian->realisasi;
                                                $penilaian->save();
                                            } elseif ($penilaian->kontrak->is_bulan) { // kasus perhitungan bulan => pada asm dan stimb
                                                $penilaian->total_realisasi = (float)$penilaian->poin * (((float)$penilaian->target - (float)$penilaian->realisasi) * ((float)$penilaian->poin / (float)$penilaian->target));
                                                $penilaian->save();
                                            } elseif ($penilaian->kontrak->is_jp) { // kasus perhitungan jam pelajaran pada unit tk, sd, smp, sma
                                                $penilaian->total_realisasi = ((float)$penilaian->realisasi * (float)$penilaian->kontrak->poin) - (0 * (float)$penilaian->kontrak->poin);
                                                $penilaian->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }




                //// jika berelasi maka nilai atasan diupdate
                //// chain reaction sampai atasan tidak memiliki atasan
                # code...
            } else {
                if ($kontrak->is_persentase) { // kasus perhitungan dengan persentase
                    $kPIPenilaian->total_realisasi = $kPIPenilaian->total > 0 ? (float)$kPIPenilaian->realisasi / (float)$kPIPenilaian->target * (float)$kontrak->poin : 0;
                    $kPIPenilaian->saveQuietly();
                } elseif ($kontrak->is_pengali) { // kasus perhitungan dengan pengali
                    $kPIPenilaian->total_realisasi = $kPIPenilaian->total > 0 ? (float)$kPIPenilaian->realisasi * (float)$kontrak->poin : 0;
                    $kPIPenilaian->saveQuietly();
                } elseif ($kontrak->is_static) { // kasus perhitungan dengan static => realisasi = total_realisasi
                    $kPIPenilaian->total_realisasi = $kPIPenilaian->realisasi;
                    $kPIPenilaian->saveQuietly();
                } elseif ($kontrak->is_bulan) { // kasus perhitungan bulan => pada asm dan stimb
                    $kPIPenilaian->total_realisasi = (float)$kPIPenilaian->poin * (((float)$kPIPenilaian->target - (float)$kPIPenilaian->realisasi) * ((float)$kPIPenilaian->poin / (float)$kPIPenilaian->target));
                    $kPIPenilaian->saveQuietly();
                } elseif ($kontrak->is_jp) { // kasus perhitungan jam pelajaran pada unit tk, sd, smp, sma
                    $kPIPenilaian->total_realisasi = ((float)$kPIPenilaian->realisasi * (float)$kontrak->poin) - (0 * (float)$kontrak->poin);
                    $kPIPenilaian->saveQuietly();
                }
            }
            $pengurangs = KPIPenilaian::where('periode_kpi_id', $kPIPenilaian->periode_kpi_id)
                ->where('user_id', $kPIPenilaian->user_id)
                ->whereHas('kontrak', function ($query) {
                    $query->where('is_komponen_pengurang', true);
                })->get();

            foreach ($pengurangs as $pengurang) {
                $pengurang->dummy = rand(1, 1000);
                $pengurang->save();
            }
        }
    }

    /**
     * Handle the KPIPenilaian "deleted" event.
     */
    public function deleted(KPIPenilaian $kPIPenilaian): void
    {
        //
    }

    /**
     * Handle the KPIPenilaian "restored" event.
     */
    public function restored(KPIPenilaian $kPIPenilaian): void
    {
        //
    }

    /**
     * Handle the KPIPenilaian "force deleted" event.
     */
    public function forceDeleted(KPIPenilaian $kPIPenilaian): void
    {
        //
    }
}
