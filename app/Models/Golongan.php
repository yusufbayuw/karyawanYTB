<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
}
