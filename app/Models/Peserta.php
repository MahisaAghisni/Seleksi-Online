<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    public $table = 'pesertas';

    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['pelatihans'];

    protected $attributes = [
        'role' => 3,
        'is_active' => 0
    ];

    // Relasi Ke Pelatihan
    public function pelatihans()
    {
        return $this->belongsTo(Pelatihan::class, 'pelatihan');
    }

    // relasi Ke WaktuUjian
    public function waktuujian()
    {
        return $this->hasMany(WaktuUjian::class);
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class, 'idGelombang');
    }

    public function getRouteKeyName()
    {
        return 'ktp';
    }
}
