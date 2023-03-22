<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use App\Models\Post;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permission_id',
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
        'permission_id' => 'required',
    );

    public function images(){
        return $this->hasMany('App\Models\Image', 'user_id');
    }

    public function movies(){
        return $this->hasMany('App\Models\Movie', 'user_id');
    }

    public function posts(){
        return $this->hasMany('App\Models\Post', 'user_id');
    }

    public function myrecipe_colections(){
        return $this->hasMany('App\Models\Myrecipe_Colection', 'user_id');
    }

    public function bookmarks(){
        return $this->hasMany('App\Models\Bookmark', 'user_id');
    }

    public function reports(){
        return $this->hasMany('App\Models\Report', 'user_id');
    }

    public function permission(){
        return $this->belongsTo('App\Models\Permission', 'permission_id');
    }

    public function isManager($user): bool {
        return User::where('id', $user->id)->where('permission_id', 3)->first() !== null;
    }

    public function getUser($user_id) {
        $user = User::find($user_id);

        return $user;
    }

    public function getIndexUser($keyword, $user) {

	$items = $user;

        if($keyword) {
            $items = User::where('name', 'LIKE', '%' . $keyword . '%')->orWhere('email', 'LIKE', '%' . $keyword . '%');
        }

        return $items;
    }

    public function getShowUser($user_id) {
        $item = User::find($user_id);
        $posts = Post::where('user_id', $item->id);
        
        return array($item, $posts);
    }

    public function getShowPost($post_id) {
        $post = Post::find($post_id);

        return $post;
    }
}


