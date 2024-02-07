<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Golongan extends Model
{
    use HasFactory;

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'golongan_id', 'id');
    }

    public function parameter(): HasMany
    {
        return $this->hasMany(Parameter::class, 'golongan_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Golongan::class, 'parent_id', 'id');
    }

    public function tingkat(): HasMany
    {
        return $this->hasMany(TingkatJabatan::class, 'jabatan_id', 'id');
    }
}
