<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiDataPanitia extends Model
{
    use HasFactory;

    public function periode(): BelongsTo
    {
        return $this->belongsTo(KPIPeriode::class, 'periode_kpi_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sk(): BelongsTo
    {
        return $this->belongsTo(KpiSkPanitia::class, 'sk_id', 'id');
    }

    public function kepanitiaan(): BelongsTo
    {
        return $this->belongsTo(KpiKepanitiaan::class, 'kpi_kepanitiaan_id', 'id');
    }
}
