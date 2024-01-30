<?php

namespace App\Observers;

use File;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Storage;
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
        if ($penilaian->file && $penilaian->getOriginal('file')) {
            if ($penilaian->file != $penilaian->getOriginal('file')) {
                Storage::disk('public')->delete($penilaian->getOriginal('file'));
            } 
        }
    }

    /**
     * Handle the Penilaian "deleted" event.
     */
    public function deleted(Penilaian $penilaian): void
    {
        Storage::disk('public')->delete([$penilaian->file]);
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
