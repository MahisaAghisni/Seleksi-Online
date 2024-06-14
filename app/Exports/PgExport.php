<?php

namespace App\Exports;

use App\Models\Ujian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PgExport implements FromView
{

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('ekspor.nilai-ujian', [
            'ujian' => $this->data
        ]);
    }
}
