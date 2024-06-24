<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }

    public function instrukturpelatihan()
    {
        return $this->hasMany(Instruktur::class);
    }

    public function ujian()
    {
        return $this->hasMany(Ujian::class);
    }

    public function detailGelombang()
    {
        return $this->hasManyThrough(DetailGelombang::class, 'id', 'idPelatihan', 'pelatihan', 'id',);
    }
}
