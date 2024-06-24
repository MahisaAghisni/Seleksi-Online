<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{

    use HasFactory;

    public $table = 'gelombangs';

    public $guarded = ['id'];

    public function pelatihans()
    {
        return $this->belongsTo(Pelatihan::class);
    }
    public function detailgelombang()
    {
        return $this->hasMany(DetailGelombang::class);
    }
    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class);
    }
    public function jenisPelatihan()
    {
        return $this->belongsTo(JenisPelatihan::class, 'jenis');
    }

    public function ujian()
    {
        return $this->hasMany(Ujian::class, 'gelombang_id', 'id');
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class, 'idGelombang');
    }

    public static function getActiveGelombang()
    {
        return self::where('is_active', 'aktif')->get();
    }
}
