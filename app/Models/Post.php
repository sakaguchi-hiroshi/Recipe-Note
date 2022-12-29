<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $rules = array(
        'user_id' => 'required',
        'myrecipe__colection_id' => 'required',
        'describe' => 'required',
    );

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function myrecipe_colection(){
        return $this->belongsTo('App\Models\Myrecipe_colection');
    }

    public function bookmarks(){
        return $this->hasMany('App\Models\Bookmark');
    }

    public function reports(){
        return $this->hasMany('App\Models\Report');
    }
}
