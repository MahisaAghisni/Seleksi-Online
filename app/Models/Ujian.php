<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    public $table = 'ujian';
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['detailujian'];

    // Relasi Ke Instruktur
    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class);
    }
    // relasi Ke pelatihan
    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }

    // relasi Ke WaktuUjian
    public function waktuujian()
    {
        return $this->hasMany(WaktuUjian::class, 'kode', 'kode');
    }

    // relasi Ke DetailUjian
    public function detailujian()
    {
        return $this->hasMany(DetailUjian::class, 'kode', 'kode');
    }

    public function detailGelombang()
    {
        return $this->hasMany(DetailGelombang::class, 'idUjian', 'id');
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class, 'gelombang_id', 'id');
    }

    public function seleksi()
    {
        return $this->hasMany(Seleksi::class, 'idUjian', 'id');
    }

    // DEFAULT KEY DI UBAH JADI KODE BUKAN ID LAGI
    public function getRouteKeyName()
    {
        return 'kode';
    }
}
