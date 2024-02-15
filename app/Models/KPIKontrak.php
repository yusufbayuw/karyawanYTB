<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KPIKontrak extends Model
{
    use HasFactory;

    public function flow(): BelongsTo
    {
        return $this->belongsTo(KPIFlow::class, 'kpi_flow_id', 'id');
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(KPIPenilaian::class, 'kpi_kontrak_id', 'id');
    }

}
