<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiKejuaraan extends Model
{
    use HasFactory;

    public function getLinkAttribute()
    {
        $prestasi = $this->prestasi ?? '';
        $jabatan = $this->jabatan ?? '';
        $kategori = $this->kategori ?? '';
        $poin = $this->poin ?? '';

        return "$prestasi - $jabatan - $kategori - $poin";
    }
}
