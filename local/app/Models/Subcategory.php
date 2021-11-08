<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\SubcategoriSpecie;

class Subcategory extends Model
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
     
    public function category(){
        return $this->belongsTo(Category::class,'categories_id');
    }

    public function getAll(){
        return Subcategory::where('status',0)->get();
    }

    public function getAllbyId($id){
        return Subcategory::where('categories_id',$id)->where('status',0)->get();
    }

 
    public function getSpecies($id){
        $categoria=SubcategoriSpecie::where('categories_id',$id)->get();
        $label="";
        foreach($categoria as $info){
            $label.="<label  class='badge badge-light mb-1'>".$info->species->name."</label>&nbsp;";

        }
        return  $label;
    }

    public static function  getSpeciesArray($id){
        $categoria=SubcategoriSpecie::select('species_id')->where('categories_id',$id)->get();
       $data=[];
        foreach($categoria as $dat){
            array_push($data,$dat->species_id);
        }
        return  $data;
    }

}
