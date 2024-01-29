<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use ModelTree;

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'jabatan_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'parent_id', 'id');
    }
}
