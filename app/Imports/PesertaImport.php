<?php

namespace App\Imports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PesertaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Peserta([
            'nik' => $row['nik'],
            'nama_peserta' => $row['nama_peserta'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'gender' => $row['gender'],
            'email' => $row['email'],
            'pelatihan_id' => $row['pelatihan_id'],
            'password' => bcrypt(str_replace('-', '', $row['tanggal_lahir'])),
            'avatar' => 'default.png',
            'role' => 3,
            'is_active' => 1
        ]);
    }
}
