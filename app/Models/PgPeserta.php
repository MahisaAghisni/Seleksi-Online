<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PgPeserta extends Model
{
    public $table = 'pg_pesertas';
    public $timestamps = false;
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['detailujian'];


    public function detailujian()
    {
        return $this->belongsTo(DetailUjian::class, 'detail_ujian_id');
    }

    public function waktuujian()
    {
        $this->belongsTo(WaktuUjian::class, 'peserta_id', 'peserta_id');
    }
}
