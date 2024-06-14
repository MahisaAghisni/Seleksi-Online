<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Guru([
            'nama_guru' => $row['nama_guru'],
            'gender' => $row['gender'],
            'email' => $row['email'],
            'password' => bcrypt('123'),
            'avatar' => 'default.png',
            'role' => 2,
            'is_active' => 1
        ]);
    }
}
