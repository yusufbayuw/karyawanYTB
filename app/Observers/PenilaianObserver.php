<?php

namespace App\Observers;

use App\Models\Penilaian;
use File;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PenilaianObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Penilaian "created" event.
     */
    public function created(Penilaian $penilaian): void
    {
        //
    }

    /**
     * Handle the Penilaian "updated" event.
     */
    public function updated(Penilaian $penilaian): void
    {
        if ($penilaian->file) {
            if ($penilaian->file != $penilaian->getOriginal('file')) {
                File::delete($penilaian->getOriginal('file'));
            } 
        }
    }

    /**
     * Handle the Penilaian "deleted" event.
     */
    public function deleted(Penilaian $penilaian): void
    {
        File::delete($penilaian->file);
    }

    /**
     * Handle the Penilaian "restored" event.
     */
    public function restored(Penilaian $penilaian): void
    {
        //
    }

    /**
     * Handle the Penilaian "force deleted" event.
     */
    public function forceDeleted(Penilaian $penilaian): void
    {
        //
    }
}
