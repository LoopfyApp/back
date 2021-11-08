<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Species;
use App\Models\Category;

class CategoriSpecie extends Model
{
    use HasFactory;

    public function add($data,$idCatgoria){
        CategoriSpecie::where('categories_id',$idCatgoria)->delete();

        foreach($data as $datSpecies){     
        $CategoriSpecie = new CategoriSpecie();
        $CategoriSpecie->categories_id=$idCatgoria;
        $CategoriSpecie->species_id=$datSpecies;
        $CategoriSpecie->save();
         }
    }
    

    public function species(){
        return $this->belongsTo(Species::class,'species_id');
    }   

    public function categories(){
        return $this->belongsTo(Category::class,'categories_id');
    }  
}
