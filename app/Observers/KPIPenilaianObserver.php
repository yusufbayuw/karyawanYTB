<?php

namespace App\Observers;

use App\Models\KPIPenilaian;
use App\Models\User;

class KPIPenilaianObserver
{
    /**
     * Handle the KPIPenilaian "created" event.
     */
    public function created(KPIPenilaian $kPIPenilaian): void
    {
        //
    }

    /**
     * Handle the KPIPenilaian "updated" event.
     */
    public function updated(KPIPenilaian $kPIPenilaian): void
    {
        $periode_id = $kPIPenilaian->periode->id;
        $kontrak = $kPIPenilaian->kontrak;
        $flow = $kontrak->flow;
        $kontrak_id = $kontrak->id;

        $urutan = $flow->urutan;

        $jabatan = $kPIPenilaian->user->jabatan_id;

        foreach ($urutan as $key => $jabatan) {
            if ($key === 0) {
                //

            } else {
                $jabatan_base_0 = $urutan[$key - 1]["jabatan"];
                $jabatan_base = $jabatan["jabatan"];
                $users_id = User::where('jabatan_id', $jabatan_base_0)->get('id')->toArray();
                $users_id = array_map(function ($item) {
                    return $item['id'];
                }, $users_id);

                $penilaian_avg = KPIPenilaian::where('kpi_kontrak_id', $kontrak_id)->whereIn('user_id', $users_id)->avg('realisasi');

                $user = User::where('jabatan_id', $jabatan_base)->first()->id;

                $id_penilaian = KPIPenilaian::where('kpi_periode_id', $periode_id)->where('user_id', $user)->where('kpi_kontrak_id', $kontrak_id)->first()->id;
                $penilaian_last = KPIPenilaian::find($id_penilaian);
                $penilaian_last->realisasi  = $penilaian_avg;
                $penilaian_last->saveQuietly();
            }
        }
    }

    /**
     * Handle the KPIPenilaian "deleted" event.
     */
    public function deleted(KPIPenilaian $kPIPenilaian): void
    {
        //
    }

    /**
     * Handle the KPIPenilaian "restored" event.
     */
    public function restored(KPIPenilaian $kPIPenilaian): void
    {
        //
    }

    /**
     * Handle the KPIPenilaian "force deleted" event.
     */
    public function forceDeleted(KPIPenilaian $kPIPenilaian): void
    {
        //
    }
}
