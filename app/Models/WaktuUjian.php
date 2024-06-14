<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuUjian extends Model
{
    public $table = 'waktu_ujian';
    public $timestamps = false;
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['peserta', 'ujian', 'pgpeserta'];


    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'kode', 'kode');
    }

    public function pgpeserta()
    {
        return $this->hasMany(PgPeserta::class, 'peserta_id', 'peserta_id');
    }
}
