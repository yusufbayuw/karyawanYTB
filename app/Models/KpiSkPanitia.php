<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiSkPanitia extends Model
{
    use HasFactory;

    public function periode(): BelongsTo
    {
        return $this->belongsTo(KPIPeriode::class, 'periode_kpi_id', 'id');
    }

    
}
