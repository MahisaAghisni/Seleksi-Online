<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelatihan extends Model
{
    use HasFactory;
    public $table = 'jenis_pelatihans';
    public function gelombang(){
        return $this->hasMany(Gelombang::class, 'jenis');
    }
}
