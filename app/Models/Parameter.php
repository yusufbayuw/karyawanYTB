<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Parameter extends Model
{
    use HasFactory, ModelTree; 
    use HasRecursiveRelationships {
        HasRecursiveRelationships::children insteadof ModelTree;
        HasRecursiveRelationships::scopeIsRoot insteadof ModelTree;
    }

    public function golongan(): BelongsTo
    {
        return $this->belongsTo(Golongan::class, 'golongan_id', 'id');
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'parameter_id', 'id');
    }
}
