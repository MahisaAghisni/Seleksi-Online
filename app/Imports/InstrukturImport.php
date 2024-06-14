<?php

namespace App\Imports;

use App\Models\Instruktur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InstrukturImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Instruktur([
            'nama_instruktur' => $row['nama_instruktur'],
            'gender' => $row['gender'],
            'email' => $row['email'],
            'password' => bcrypt('123'),
            'avatar' => 'default.png',
            'role' => 4,
            'is_active' => 1
        ]);
    }
}
