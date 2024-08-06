<?php

namespace App\Observers;

use App\Models\KpiKejuaraan;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class KpiKejuaraanObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the KpiKejuaraan "created" event.
     */
    public function created(KpiKejuaraan $kpiKejuaraan): void
    {
        $prestasi = $kpiKejuaraan->prestasi ?? '';
        $jabatan = $kpiKejuaraan->jabatan ?? '';
        $kategori = $kpiKejuaraan->kategori ?? '';
        $poin = number_format($kpiKejuaraan->poin, 2, '.') ?? '';

        $kpiKejuaraan->link = "$jabatan - $kategori - $prestasi - $poin";
        $kpiKejuaraan->saveQuietly();
    }

    /**
     * Handle the KpiKejuaraan "updated" event.
     */
    public function updated(KpiKejuaraan $kpiKejuaraan): void
    {
        $prestasi = $kpiKejuaraan->prestasi ?? '';
        $jabatan = $kpiKejuaraan->jabatan ?? '';
        $kategori = $kpiKejuaraan->kategori ?? '';
        $poin = number_format($kpiKejuaraan->poin, 2, '.') ?? '';

        $kpiKejuaraan->link = "$jabatan - $kategori - $prestasi - $poin";
        $kpiKejuaraan->saveQuietly();
    }

    /**
     * Handle the KpiKejuaraan "deleted" event.
     */
    public function deleted(KpiKejuaraan $kpiKejuaraan): void
    {
        //
    }

    /**
     * Handle the KpiKejuaraan "restored" event.
     */
    public function restored(KpiKejuaraan $kpiKejuaraan): void
    {
        //
    }

    /**
     * Handle the KpiKejuaraan "force deleted" event.
     */
    public function forceDeleted(KpiKejuaraan $kpiKejuaraan): void
    {
        //
    }
}
