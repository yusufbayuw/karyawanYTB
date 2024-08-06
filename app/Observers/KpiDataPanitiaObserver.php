<?php

namespace App\Observers;

use App\Models\KpiDataPanitia;
use App\Models\KPIPenilaian;

class KpiDataPanitiaObserver
{
    /**
     * Handle the KpiDataPanitia "created" event.
     */
    public function created(KpiDataPanitia $kpiDataPanitia): void
    {
        $user_id = $kpiDataPanitia->user_id;
        $periode_id = $kpiDataPanitia->periode_kpi_id;

        $kepanitiaan = KPIPenilaian::where('periode_kpi_id', $periode_id)
            ->where('user_id', $user_id)
            ->whereHas('kontrak', function ($query) {
                $query->where('is_kepanitiaan', true);
            })
            ->first();
        if ($kepanitiaan) {
            $poins = KpiDataPanitia::where('user_id', $user_id)
                ->where('periode_kpi_id', $periode_id)
                ->withSum('kepanitiaan', 'poin')
                ->get();
            if ($poins) {
                $dummy = [];

                foreach ($poins as $poin) {
                    $dummy[] = [
                        "nama" => $poin->sk->nama,
                        "jenis" => $poin->kepanitiaan->jenis,
                        "penugasan" => $poin->kepanitiaan->penugasan,
                        "poin" => $poin->kepanitiaan->poin
                    ];
                }
                //dd(json_encode($dummy, JSON_UNESCAPED_SLASHES));
                $kepanitiaan->rincian_kepanitiaan = $dummy;
                $kepanitiaan->realisasi = $poins->sum('kepanitiaan_sum_poin');
                $kepanitiaan->total_realisasi = $poins->sum('kepanitiaan_sum_poin');
                $kepanitiaan->save();
            }
        }
    }

    /**
     * Handle the KpiDataPanitia "updated" event.
     */
    public function updated(KpiDataPanitia $kpiDataPanitia): void
    {
        $user_id = $kpiDataPanitia->user_id;
        $periode_id = $kpiDataPanitia->periode_kpi_id;

        $kepanitiaan = KPIPenilaian::where('periode_kpi_id', $periode_id)
            ->where('user_id', $user_id)
            ->whereHas('kontrak', function ($query) {
                $query->where('is_kepanitiaan', true);
            })
            ->first();
        if ($kepanitiaan) {
            $poins = KpiDataPanitia::where('user_id', $user_id)
                ->where('periode_kpi_id', $periode_id)
                ->withSum('kepanitiaan', 'poin')
                ->get();
            if ($poins) {
                $dummy = [];

                foreach ($poins as $poin) {
                    $dummy[] = [
                        "nama" => $poin->sk->nama,
                        "jenis" => $poin->kepanitiaan->jenis,
                        "penugasan" => $poin->kepanitiaan->penugasan,
                        "poin" => $poin->kepanitiaan->poin
                    ];
                }
                //dd(json_encode($dummy, JSON_UNESCAPED_SLASHES));
                $kepanitiaan->rincian_kepanitiaan = $dummy;
                $kepanitiaan->realisasi = $poins->sum('kepanitiaan_sum_poin');
                $kepanitiaan->total_realisasi = $poins->sum('kepanitiaan_sum_poin');
                $kepanitiaan->save();
            }
        }
    }

    /**
     * Handle the KpiDataPanitia "deleted" event.
     */
    public function deleted(KpiDataPanitia $kpiDataPanitia): void
    {
        //
    }

    /**
     * Handle the KpiDataPanitia "restored" event.
     */
    public function restored(KpiDataPanitia $kpiDataPanitia): void
    {
        //
    }

    /**
     * Handle the KpiDataPanitia "force deleted" event.
     */
    public function forceDeleted(KpiDataPanitia $kpiDataPanitia): void
    {
        //
    }
}
