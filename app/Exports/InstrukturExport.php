<?php

namespace App\Exports;

use App\Models\Instruktur;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InstrukturExport implements FromView
{
    public function view(): View
    {
        return view('ekspor.instruktur', [
            'instruktur' => Instruktur::all()
        ]);
    }
}
