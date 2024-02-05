<?php

namespace App\Observers;

use App\Models\Periode;

class PeriodeObserver
{
    /**
     * Handle the Periode "created" event.
     */
    public function created(Periode $periode): void
    {
        if ($periode->is_active) {
            Periode::where('is_active', true)->update(['is_active' => false]);
            $periode->is_active = true;
            $periode->save();
        }
    }

    /**
     * Handle the Periode "updated" event.
     */
    public function updated(Periode $periode): void
    {
        if ($periode->is_active) {
            Periode::where('is_active', true)->update(['is_active' => false]);
            $periode->is_active = true;
            $periode->save();
        }
    }

    /**
     * Handle the Periode "deleted" event.
     */
    public function deleted(Periode $periode): void
    {
        //
    }

    /**
     * Handle the Periode "restored" event.
     */
    public function restored(Periode $periode): void
    {
        //
    }

    /**
     * Handle the Periode "force deleted" event.
     */
    public function forceDeleted(Periode $periode): void
    {
        //
    }
}
