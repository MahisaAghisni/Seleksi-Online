<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seleksi extends Model
{
    public $timestamps = false;
    use HasFactory;
    public $table = 'seleksi';

    public function pelatihans()
    {
        return $this->belongsTo(Pelatihan::class, 'idPelatihan');
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class, 'idGelombang');
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'idUjian');
    }
}
