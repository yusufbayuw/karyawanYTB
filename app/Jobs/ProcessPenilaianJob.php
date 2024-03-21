<?php

namespace App\Jobs;

use App\Models\Laporan;
use App\Models\Periode;
use App\Models\Penilaian;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessPenilaianJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $periodes = Periode::all();
        $penilaians = Penilaian::all();

        foreach ($periodes as $key => $periode) {
            $penilaianPeriode = $penilaians->where('periode_id', $periode->id);

            if ($penilaianPeriode->isNotEmpty()) {
                $userUnik = $penilaianPeriode->unique('user_id')->pluck('user_id');

                foreach ($userUnik as $key => $user) {
                    $penilaian_filter = Penilaian::where('periode_id', $periode->id)
                        ->where('user_id', $user);
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
                        ['periode_id' => $periode->id, 'user_id' => $user],
                        [
                            'unverified' => $unverified,
                            'revision' => $revision,
                            'verified' => $verified,
                        ]
                    );
                }
            }
        }

        Notification::make()
            ->title('Sinkronisasi laporan AK berhasil.')
            ->success()
            ->send();
    }
}
