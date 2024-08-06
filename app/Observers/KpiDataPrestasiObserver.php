<?php

namespace App\Observers;

use App\Models\KPIPenilaian;
use App\Models\KpiDataPrestasi;

class KpiDataPrestasiObserver
{
    /**
     * Handle the KpiDataPrestasi "created" event.
     */
    public function created(KpiDataPrestasi $kpiDataPrestasi): void
    {
        $user_id = $kpiDataPrestasi->user_id;
        $periode_id = $kpiDataPrestasi->periode_kpi_id;
        $kejuaraan = KPIPenilaian::where('periode_kpi_id', $periode_id)
            ->where('user_id', $user_id)
            ->whereHas('kontrak', function ($query) use ($kpiDataPrestasi) {
                $query->where('is_kejuaraan', true)->where('job_code', 'LIKE', "%{$kpiDataPrestasi->kejuaraan->job_code}%")->where('kpi', $kpiDataPrestasi->kejuaraan->prestasi);
            })
            ->first();
            //dd($kejuaraan->kontrak->kpi);
        if ($kejuaraan) {
            $poins = KpiDataPrestasi::where('user_id', $user_id)
                ->where('periode_kpi_id', $periode_id)
                ->whereHas('kejuaraan', function ($query) use ($kpiDataPrestasi) {
                    $query->where('prestasi', $kpiDataPrestasi->kejuaraan->prestasi);
                })
                ->withSum('kejuaraan', 'poin')
                ->get();
                //dd($poins);
            if ($poins) {
                $dummy = [];

                foreach ($poins as $poin) {
                    $dummy[] = [
                        "ajang" => $poin->nama,
                        "jabatan" => $poin->kejuaraan->jabatan,
                        "kategori" => $poin->kejuaraan->kategori,
                        "poin" => $poin->kejuaraan->poin,
                        //"file" => $poin->file,
                    ];
                }
                //dd(json_encode($dummy, JSON_UNESCAPED_SLASHES));
                $kejuaraan->rincian_prestasi = $dummy;
                $kejuaraan->realisasi = $poins->sum('kejuaraan_sum_poin');
                $kejuaraan->total_realisasi = $poins->sum('kejuaraan_sum_poin');
                $kejuaraan->save();
            }
        }
    }

    /**
     * Handle the KpiDataPrestasi "updated" event.
     */
    public function updated(KpiDataPrestasi $kpiDataPrestasi): void
    {
        //
    }

    /**
     * Handle the KpiDataPrestasi "deleted" event.
     */
    public function deleted(KpiDataPrestasi $kpiDataPrestasi): void
    {
        //
    }

    /**
     * Handle the KpiDataPrestasi "restored" event.
     */
    public function restored(KpiDataPrestasi $kpiDataPrestasi): void
    {
        //
    }

    /**
     * Handle the KpiDataPrestasi "force deleted" event.
     */
    public function forceDeleted(KpiDataPrestasi $kpiDataPrestasi): void
    {
        //
    }
}
