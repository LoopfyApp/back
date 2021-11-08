<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CommentsPostsPets extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->belongsTo(PostsPets::class, 'posts_pets_id');
    }

    public function getCommentsAttribute($value)
    {
        return utf8_decode($value);
    }

    public function pets()
    {
        return $this->belongsTo(UsersSpecie::class, 'users_pets_id');
    }

    public function getCreatedAtAtrribute($value){
        return Carbon::parse($value)->diffForHumans();
    }
}
