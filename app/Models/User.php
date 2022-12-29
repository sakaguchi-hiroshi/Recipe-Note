<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = array(
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
        'role' => 'required',
    );

    public function images(){
        return $this->hasMany('App\Models\Image', 'image_id');
    }

    public function movies(){
        return $this->hasMany('App\Models\Movie', 'movie_id');
    }

    public function myrecipe_colections(){
        return $this->hasMany('App\Models\Myrecipe_Colection', 'myrecipe__colection_id');
    }

    public function bookmarks(){
        return $this->hasMany('App\Models\Bookmark', 'bookmark_id');
    }

    public function reports(){
        return $this->hasMany('App\Models\Report', 'report_id');
    }
}
