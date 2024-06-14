<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileModel extends Model
{
    public $table = 'files';
    use HasFactory;
    protected $guard = ['id'];
}
