<?php

namespace App\Observers;

use App\Models\KPIKontrak;

class KPIKontrakObserver
{
    /**
     * Handle the KPIKontrak "created" event.
     */
    public function created(KPIKontrak $kPIKontrak): void
    {
        $unitName = $kPIKontrak->unit_kpi->code ?? '';
        $jabatanName = $kPIKontrak->job_code ?? ''; //$kPIKontrak->jabatan->code ?? '';
        $order = $kPIKontrak->order ?? '';
        $kpi = $kPIKontrak->kpi ?? '';

        $kPIKontrak->unit_id = $kPIKontrak->unit_kpi->unit->id ?? '';
        $kPIKontrak->code = "$unitName-$jabatanName.$order";
        $kPIKontrak->kpi_code = "($unitName-$jabatanName.$order) $kpi";
        $kPIKontrak->saveQuietly();
    }

    /**
     * Handle the KPIKontrak "updated" event.
     */
    public function updated(KPIKontrak $kPIKontrak): void
    {
        $unitName = $kPIKontrak->unit_kpi->code ?? '';
        $jabatanName = $kPIKontrak->job_code ?? ''; //$kPIKontrak->jabatan->code ?? '';
        $order = $kPIKontrak->order ?? '';
        $kpi = $kPIKontrak->kpi ?? "";

        $kPIKontrak->unit_id = $kPIKontrak->unit_kpi->unit->id ?? '';
        $kPIKontrak->code = "$unitName-$jabatanName.$order";
        $kPIKontrak->kpi_code = "($unitName-$jabatanName.$order) $kpi";
        $kPIKontrak->saveQuietly();
    }

    /**
     * Handle the KPIKontrak "deleted" event.
     */
    public function deleted(KPIKontrak $kPIKontrak): void
    {
        //
    }

    /**
     * Handle the KPIKontrak "restored" event.
     */
    public function restored(KPIKontrak $kPIKontrak): void
    {
        //
    }

    /**
     * Handle the KPIKontrak "force deleted" event.
     */
    public function forceDeleted(KPIKontrak $kPIKontrak): void
    {
        //
    }
}
