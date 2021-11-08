<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public function getLogoAttribute($value)
    {
        if($value=='null')
        {
            
            return asset("images/no-camaras.png");
        }
        return asset("local/storage/app/public/".$value);
    }

}
