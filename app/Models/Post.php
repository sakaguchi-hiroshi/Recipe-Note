<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bookmark;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $rules = array(
        'user_id' => 'required',
        'myrecipe__colection_id' => 'required',
    );

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function myrecipe_colection(){
        return $this->belongsTo('App\Models\Myrecipe_colection', 'myrecipe__colection_id');
    }

    public function bookmarks(){
        return $this->hasMany('App\Models\Bookmark', 'post_id');
    }

    public function reports(){
        return $this->hasMany('App\Models\Report', 'post_id');
    }

    public function isLikedBy($user): bool {
        return Bookmark::where('user_id', $user->id)->where('post_id', $this->id)->first() !== null;
    }

    public function getPostRecipeRanking($results)
    {
        $post_recipe_ids = array_keys($results);
        $ids_order = implode(',', $post_recipe_ids);
        $post_recipe_ranking = $this->whereIn('id', $post_recipe_ids)
                                    ->orderByRaw("FIELD(id, $ids_order)")
                                    ->paginate(10);
        return $post_recipe_ranking;
    }
}
