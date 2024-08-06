<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiPejabat extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kpi_jabatan(): BelongsTo
    {
        return $this->belongsTo(KpiJabatan::class, 'kpi_jabatan_id', 'id');
    }
}
