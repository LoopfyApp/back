<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Species;

class Breed extends Model
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

    public function species(){
        return $this->belongsTo(Species::class,'species_id');
}
        
}
