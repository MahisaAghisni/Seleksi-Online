<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrukturpelatihan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $with = ['instruktur', 'pelatihan'];

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class);
    }

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}
