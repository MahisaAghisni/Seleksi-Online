<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;

    public function gelombang(){
        return $this->hasMany(Gelombang::class, 'anggaran_id');
    }
}
