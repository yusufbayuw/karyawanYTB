<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiKepanitiaan extends Model
{
    use HasFactory;

    public function getLinkAttribute()
    {
        $jenis = $this->jenis ?? '';
        $penugasan = $this->penugasan ?? '';
        $poin = $this->poin ?? '';

        return "$jenis - $penugasan - $poin";
    }
}
