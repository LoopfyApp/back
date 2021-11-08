<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Species;
use App\Models\Subcategory;

class SubcategoriSpecie extends Model
{
    use HasFactory;

    public function species(){
        return $this->belongsTo(Species::class,'species_id');
    }   

    public function subcategories(){
        return $this->belongsTo(Subcategory::class,'categories_id');
    } 


    public function add($data,$idCatgoria){
        SubcategoriSpecie::where('categories_id',$idCatgoria)->delete();

        foreach($data as $datSpecies){     
        $Subcategory = new SubcategoriSpecie();
        $Subcategory->categories_id=$idCatgoria;
        $Subcategory->species_id=$datSpecies;
        $Subcategory->save();
         }
    }
    

}
