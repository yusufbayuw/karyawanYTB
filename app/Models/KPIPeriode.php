<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KPIPeriode extends Model
{
    use HasFactory;

    public function penilaian(): HasMany
    {
        return $this->hasMany(KPIPenilaian::class, 'kpi_periode_id', 'id');
    }
}
