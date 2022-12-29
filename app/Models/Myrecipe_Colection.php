<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Myrecipe_Colection extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $rules = array(
        'user_id' => 'required',
        'title' => 'required',
    );

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function image(){
        return $this->belongsTo('App\Models\Image', 'image_id');
    }

    public function movie(){
        return $this->belongsTo('App\Models\Movie', 'movie_id');
    }

    public function posts(){
        return $this->hasMany('App\Models\Post', 'post_id');
    }
}
