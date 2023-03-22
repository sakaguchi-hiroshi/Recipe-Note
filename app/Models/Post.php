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
        return $this->belongsTo('App\Models\Myrecipe_Colection', 'myrecipe__colection_id');
    }

    public function bookmarks(){
        return $this->hasMany('App\Models\Bookmark', 'post_id');
    }

    public function reports(){
        return $this->hasMany('App\Models\Report', 'post_id');
    }

    public function getIndexPosts($keyword, $value) {

        if($value == 'post') {
            $posts = Post::whereHas('myrecipe_colection', function ($q) use ($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
            });
        }else {
            $posts = Post::with('myrecipe_colection.movie')
            ->whereHas('myrecipe_colection.movie', function($q) {
                $q->whereExists(function($q){
                    return $q;
                });
            })
            ->whereHas('myrecipe_colection', function ($q) use ($keyword) {
                    $q->where('title', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
            });
        }

        return $posts;
    }

    public function getPostRecipe($recipe_id) {
        return Post::where('myrecipe__colection_id', $recipe_id);
    }

    public function isLikedBy($user): bool {
        return Bookmark::where('user_id', $user->id)->where('post_id', $this->id)->first() !== null;
    }

    public function getBookmarkOrderPosts($keyword) {
        $posts = Post::withCount('bookmarks')
        ->whereHas('myrecipe_colection', function($q) use($keyword) {
            $q->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
        })
        ->orderBy('bookmarks_count', 'desc');

        return $posts;
    }

    public function getPostRecipeRanking($results, $keyword)
    {
        $post_recipe_ids = array_keys($results);
        $ids_order = implode(',', $post_recipe_ids);
        $post_recipe_ranking = $this->whereIn('id', $post_recipe_ids)
        ->orderByRaw("FIELD(id, $ids_order)")
        ->whereHas('myrecipe_colection', function($q) use($keyword) {
            $q->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
        });
        
        return $post_recipe_ranking;
    }

}
