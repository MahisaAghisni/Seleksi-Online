<?php

namespace App\Exports;

use App\Models\Guru;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GuruExport implements FromView
{
    public function view(): View
    {
        return view('ekspor.guru', [
            'guru' => Guru::all()
        ]);
    }
}
