<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

  public function getPhotoAttribute($value)
    {
        if($value==null)
        {
            
            return asset("images/no-camaras.png");
        }
        return asset("local/storage/app/public/".$value);
    }

    public function urlphoto($value){
        return asset("local/storage/app/public/".$value);
    }

    public function categories(){
        return $this->belongsTo(Category::class,'category_id');
    }  


    public function marcas(){
        return $this->belongsTo(Brand::class,'marca_id');
    }  

    public function details()
    {
        return $this->hasMany(ProductDetail::class, 'prdoucto_id')->toarray();
    }

    public function speciesArrays($datos){
        $species='';
            foreach($datos as $data){
                    $species.=$data.",";
            }
            return substr($species,0,-1);
    }

}
