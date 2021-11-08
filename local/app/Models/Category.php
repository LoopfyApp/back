<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoriSpecie;
class Category extends Model
{
    use HasFactory;

    public function getLogoAttribute($value)
    {
        return asset("local/storage/app/public/".$value);
    }

    public function getSpecies($id){
        $categoria=CategoriSpecie::where('categories_id',$id)->get();
        $label="";
        foreach($categoria as $info){
            $label.="<label  class='badge badge-light mb-1'>".$info->species->name."</label>&nbsp;";

        }
        return  $label;
    }

    public static function  getSpeciesArray($id){
        $categoria=CategoriSpecie::select('species_id')->where('categories_id',$id)->get();
       $data=[];
        foreach($categoria as $dat){
            array_push($data,$dat->species_id);
        }
        return  $data;
    }

    

    public static function  getSpeciesDataArray($id){
        $categoria=CategoriSpecie::select('species_id')->where('categories_id',$id)->get();
       $data=[];
        foreach($categoria as $dat){
            $new['id']=$dat->species_id; 
            $new['name']=$dat->species->name;

            array_push($data,$new);
        }
        return  $data;
    }

    public function getAll(){
        return Category::where('status',0)->get();
    }
}
