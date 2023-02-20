<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $rules = array(
        'user_id' => 'required',
        'comment' => 'required',
    );

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function image(){
        return $this->belongsTo('App\Models\Image', 'image_id');
    }

    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id');
    }
}
