<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KPIPenilaian extends Model
{
    use HasFactory;

    protected $casts = [
        'rincian_kepanitiaan' => 'json',
        'rincian_prestasi' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function periode(): BelongsTo
    {
        return $this->belongsTo(KPIPeriode::class, 'periode_kpi_id', 'id');
    }

    public function kontrak(): BelongsTo
    {
        return $this->belongsTo(KPIKontrak::class, 'kpi_kontrak_id', 'id');
    }

}
