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
                    ->whereHas('kontrak', function ($query) {
                        $query->where('is_komponen_pengurang', false);
                    })->sum('total_realisasi');

                $kPIPenilaian->total_realisasi = (-1) * ((100 - $kPIPenilaian->realisasi) / 100) * $sumAll / 2;
                $kPIPenilaian->saveQuietly();
            } elseif ($kontrak->kpi = "Persentase keluhan terhadap layanan yang diberikan") {
                $sumAll = KPIPenilaian::where('periode_kpi_id', $kPIPenilaian->periode_kpi_id)
                    ->where('user_id', $kPIPenilaian->user_id)
                    ->whereHas('kontrak', function ($query) {
                        $query->where('is_komponen_pengurang', false);
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
            } else {
                if ($kontrak->currency === '%') {
                    $kPIPenilaian->total_realisasi = $kPIPenilaian->total > 0 ? (float)$kPIPenilaian->realisasi / (float)$kPIPenilaian->target * (float)$kontrak->poin : 0;
                    $kPIPenilaian->saveQuietly();
                } else {
                    $kPIPenilaian->total_realisasi = $kPIPenilaian->total > 0 ? (float)$kPIPenilaian->realisasi * (float)$kontrak->poin : 0;
                    $kPIPenilaian->saveQuietly();
                }
            }
            $pengurangs = KPIPenilaian::where('periode_kpi_id', $kPIPenilaian->periode_kpi_id)
                ->where('user_id', $kPIPenilaian->user_id)
                ->whereHas('kontrak', function ($query) {
                    $query->where('is_komponen_pengurang', true);
                })->get();
        
            foreach ($pengurangs as $pengurang) {
                $pengurang->dummy = rand(1,1000);
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
