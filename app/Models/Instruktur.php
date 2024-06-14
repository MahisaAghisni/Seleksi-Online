<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruktur extends Model
{
    public $table = 'instrukturs';

    use HasFactory;

    protected $guarded = ['id'];

    protected $attributes = [
        'avatar' => 'default.png',
        'role' => 2,
        'is_active' => 0
    ];

    // Relasi Ke Instrukturpelatihan
    public function instrukturpelatihan()
    {
        return $this->hasMany(Instrukturpelatihan::class);
    }

    // Relasi Ke Ujian
    public function ujian()
    {
        return $this->hasMany(Ujian::class);
    }
}
