<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;


    public function getLogoAttribute($value)
    {
        return asset("local/storage/app/public/".$value);
    }
 
    public function getAll(){
        return Species::where('status',0)->orderby('name','asc')->get();
    }
}
