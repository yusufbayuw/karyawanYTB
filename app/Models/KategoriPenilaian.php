<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriPenilaian extends Model
{
    use HasFactory;
    public function parameter(): HasMany
    {
        return $this->hasMany(Parameter::class, 'kategori_id', 'id');
    }
}
