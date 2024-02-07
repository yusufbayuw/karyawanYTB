<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class TingkatJabatan extends Model
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
}
