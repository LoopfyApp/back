<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use HasFactory;

    public function listbanco(){
        return $this->belongsTo(ListBank::class,'bank_code');
    }
}
