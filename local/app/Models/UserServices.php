<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserServices extends Model
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

    public function categories(){
        return $this->belongsTo(Category::class,'category_id');
    }  

    public function hours($id){
         return UserServicesHours::select('days')->where('user_services_id', $id)->groupby('days')->get();
    } 

    
    public function hoursArrays($id){
        $info=UserServicesHours::select('days')->where('user_services_id', $id)->groupby('days')->get();
        $datoshorius='';
        foreach($info as $datos){
                $datoshorius.=$datos->days.",";
        }
        return substr($datoshorius,0,-1);

   } 

   public function speciesArrays($id){
            $info=UserServicesSpecies::select('species_id')->where('user_services_id', $id)->get();
            $datoshorius='';
            foreach($info as $datos){
                    $datoshorius.=$datos->species_id.",";
            }
            return substr($datoshorius,0,-1);
} 

    public function servicesspecies(){
        return $this->belongsTo(UserServicesSpecies::class,'user_services_id');
    } 
}
