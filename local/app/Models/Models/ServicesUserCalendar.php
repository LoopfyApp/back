<?php

namespace App\Models\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesUserCalendar extends Model
{
    use HasFactory;

    public function userInfo(){
        return $this->belongsTo(User::class,'users_id');
    }
    public function storeInfo(){
        return $this->belongsTo(User::class,'user_store_id');
    }
    
    public function datailsInfo(){
        return $this->belongsTo(ServicesUserCalendarDetails::class,'id','services_user_calendars');
    }
}
