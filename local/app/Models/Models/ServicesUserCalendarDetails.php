<?php

namespace App\Models\Models;

use App\Models\UserServices;
use App\Models\UsersSpecie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesUserCalendarDetails extends Model
{
    use HasFactory;

    
    public function datailsServicio(){
        return $this->belongsTo(UserServices::class,'user_services_id');
    }

   

    public function infoMascote(){
        return $this->belongsTo(UsersSpecie::class,'users_species');

    }

}
