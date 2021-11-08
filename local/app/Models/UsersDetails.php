<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersDetails extends Model
{
    use HasFactory;

    public function add($data,$idUsers){

        $datos= new UsersDetails();

        $datos->users_id=$idUsers;
        $datos->cep=$data->cep;
        $datos->cnpj=$data->cnpj;
        $datos->razon=$data->razon;
        $datos->address=$data->address;
        $datos->complemento=$data->complemento;
        $datos->phone=$data->phone;
        $datos->save();
    }

    public function getPhotoAttribute($value)
    {
        if($value==null)
        {
            
            return asset("images/no-camaras.png");
        }
        return asset("local/storage/app/public/".$value);
    }

    public function getLogoAttribute($value)
    {
        if($value==null)
        {
            
            return asset("images/no-camaras.png");
        }
        return asset("local/storage/app/public/".$value);
    }
}
