<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiDataPrestasi extends Model
{
    use HasFactory;

    public function periode(): BelongsTo
    {
        return $this->belongsTo(KPIPeriode::class, 'periode_kpi_id', 'id');
    }

    public function kejuaraan(): BelongsTo
    {
        return $this->belongsTo(KpiKejuaraan::class, 'kpi_kejuaraan_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
