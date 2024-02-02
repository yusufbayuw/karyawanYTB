<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penilaian extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'id');
    }

    public function parameter(): BelongsTo
    {
        return $this->belongsTo(Parameter::class, 'parameter_id', 'id');
    }
}
