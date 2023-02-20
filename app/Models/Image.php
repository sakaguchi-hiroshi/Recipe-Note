<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $rules = array(
        'user_id' => 'required',
        'name' => 'required',
        'path' => 'required',
    );

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function myrecipe_colections(){
        return $this->hasMany('App\Models\Myrecipe_Colection', 'image_id');
    }

    public function reports(){
        return $this->hasMany('App\Models\Report', 'image_id');
    }
}
