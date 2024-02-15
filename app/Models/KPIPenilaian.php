<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KPIPenilaian extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function periode(): BelongsTo
    {
        return $this->belongsTo(KPIPeriode::class, 'kpi_periode_id', 'id');
    }

    public function kontrak(): BelongsTo
    {
        return $this->belongsTo(KPIKontrak::class, 'kpi_kontrak_id', 'id');
    }

}
