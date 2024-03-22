<?php

namespace App\Observers;

use App\Models\Laporan;
use App\Models\Penilaian;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PenilaianAfterCommitObserver implements ShouldHandleEventsAfterCommit
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

        $penilaian_filter = Penilaian::where('periode_id', $penilaian->periode_id)
            ->where('user_id', $penilaian->user_id);
        $unverified = $penilaian_filter
            ->whereNotNull('file')
            ->whereNull('komentar')
            ->where('approval', false)
            ->count();
        $revision = $penilaian_filter
            ->whereNotNull('file')
            ->whereNotNull('komentar')
            ->where('approval', false)
            ->count();
        $verified = $penilaian_filter
            ->whereNotNull('file')
            ->whereNull('komentar')
            ->where('approval', true)
            ->count();
        Laporan::updateOrCreate(
            ['periode_id' => $penilaian->periode_id, 'user_id' => $penilaian->user_id],
            [
                'unverified' => $unverified,
                'revision' => $revision,
                'verified' => $verified,
            ]
        );
    }

    /**
     * Handle the Penilaian "deleted" event.
     */
    public function deleted(Penilaian $penilaian): void
    {
        //
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
