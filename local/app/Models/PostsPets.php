<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PostsPets extends Model
{
    use HasFactory;

    protected $appends = array('favorites_count','id_favorites','followeroptions');

    
    public function getFolloweroptionsAttribute()
    {
         
        return FollowPostsPets::where('users_id',Auth::user()->id)->where('users_pets_follow_id',$this->users_pets_id)->first();
    }
 
    public function getFavoritesCountAttribute()
    {
         
        return FavoritePostsPets::where('users_id',Auth::user()->id)->where('posts_pets_id',$this->id)->count();
    }

    public function getIdFavoritesAttribute()
    {
         
        $favorite=FavoritePostsPets::where('users_id',Auth::user()->id)->where('posts_pets_id',$this->id)->first();
        if($favorite){
            return $favorite->id;
        }
        else{
            return 0;
        }
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function pets()
    {
        return $this->belongsTo(UsersSpecie::class, 'users_pets_id');
    }

    public function comenets()
    {
        return $this->hasMany(CommentsPostsPets::class, 'posts_pets_id');
    }
    
    public function favoritepets()
    {
        return $this->belongsTo(FavoritePostsPets::class, 'users_pets_id','users_pets_id');
    }
    
    public function favorite()
    {
        return $this->hasMany(FavoritePostsPets::class, 'users_id','users_id');
    }


    public function getPhotoAttribute($value)
    {
        return asset("local/storage/app/public/".$value);
    }

    
    public function getDescriptionAttribute($value)
    {
        return utf8_decode($value);
    }

    public function getdatepostAtrribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

}
