<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KPIFlow extends Model
{
    use HasFactory;

    protected $casts = [
        'urutan' => 'json',
    ];

    public function kontrak(): HasMany
    {
        return $this->hasMany(KPIKontrak::class, 'kpi_flow_id', 'id');
    }
}
