<?php

namespace App\Models;
use Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $casts = [
        'transcations' => 'array',
    ];
 
}
