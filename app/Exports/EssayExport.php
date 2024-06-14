<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EssayExport implements FromView
{
    public function __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('ekspor.nilai-essay', [
            'ujian' => $this->data
        ]);
    }
}
