<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KPIKontrak extends Model
{
    use HasFactory;

    /* // Definisikan accessor untuk kpi_code
    public function getCodeAttribute()
    {
        $unitName = $this->unit->code ?? '';
        $jabatanName = $this->jabatan->code ?? '';
        $order = $this->order ?? '';

        return "$unitName-$jabatanName.$order";
    }

    public function getKpiCodeAttribute()
    {
        $code = $this->code ?? '';
        $kpi = $this->kpi ?? '';

        return "($code) $kpi";
    } */

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function unit_kpi(): BelongsTo
    {
        return $this->belongsTo(UnitKpi::class, 'unit_kpi_id', 'id');
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(KPIPenilaian::class, 'kpi_kontrak_id', 'id');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(KPIPeriode::class, 'periode_kpi_id', 'id');
    }

    public function terusan(): BelongsTo
    {
        return $this->belongsTo(KPIKontrak::class, 'parent_id', 'id');
    }

    public function children(): BelongsTo
    {
        return $this->belongsTo(KPIKontrak::class, 'parent_id', 'id');
    }

}
