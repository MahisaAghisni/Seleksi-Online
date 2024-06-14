<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $attributes = [
        'avatar' => 'default.png',
        'role' => 1,
        'is_active' => 1
    ];
}
