<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $rules = array(
        'user_id' => 'required',
        'post_id' => 'required',
    );

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id');
    }
}
