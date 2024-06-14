<?php

namespace App\Imports;

use App\Models\DetailUjian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;

class PgImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation
{

    public function  __construct($kode)
    {
        $this->kode = $kode;
    }

    public function rules(): array
    {
        return [
            'soal' => ['required'],
            'pg_1' => ['required'],
            'pg_2' => ['required'],
            'pg_3' => ['required'],
            'pg_4' => ['required'],
            'pg_5' => ['required'],
            'jawaban' => ['required'],
        ];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new DetailUjian([
            'kode'    => $this->kode,
            'soal'    => $row['soal'],
            'pg_1'    => 'A. ' . $row['pg_1'],
            'pg_2'    => 'B. ' . $row['pg_2'],
            'pg_3'    => 'C. ' . $row['pg_3'],
            'pg_4'    => 'D. ' . $row['pg_4'],
            'pg_5'    => 'E. ' . $row['pg_5'],
            'jawaban' => $row['jawaban'],
        ]);
    }
}
