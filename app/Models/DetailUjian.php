<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUjian extends Model
{
    public $table = 'detail_ujian';
    use HasFactory;
    protected $guarded = ['id'];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    // // Relasi ke Pg Siswa
    // public function pgsiswa()
    // {
    //     return $this->hasMany(DetailUjian::class);
    // }
}
