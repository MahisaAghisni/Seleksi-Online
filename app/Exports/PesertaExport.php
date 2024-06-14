<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PesertaExport implements FromView
{
    public function view(): View
    {
        return view('ekspor.peserta', [
            'peserta' => Peserta::all()
        ]);
    }
}
