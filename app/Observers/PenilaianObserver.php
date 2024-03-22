<?php

namespace App\Observers;

use App\Models\Penilaian;
use Illuminate\Support\Facades\Storage;

class PenilaianObserver //implements ShouldHandleEventsAfterCommit
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
        if ($penilaian->file || $penilaian->getOriginal('file')) {
            if ($penilaian->file != $penilaian->getOriginal('file')) {
                if ($penilaian->getOriginal('file')) {
                    //Storage::disk('public')->delete($penilaian->getOriginal('file'));
                    unlink(public_path('storage/'.$penilaian->getOriginal('file')));
                }
            }
        }
    }

    /**
     * Handle the Penilaian "deleted" event.
     */
    public function deleted(Penilaian $penilaian): void
    {
        if ($penilaian->file) {
            # code...
            //Storage::disk('public')->delete([$penilaian->file]);
            unlink(public_path('storage/'.$penilaian->file));
        }
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
