<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PenilaianExport;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianController extends Controller
{
    public function export() 
    {
        return Excel::download(new PenilaianExport, 'penialaian-'.now().'.xlsx');
    }
}
