<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\Bookmark;
use App\Models\Report;
use App\Services\RankingService;

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
        return $this->hasMany('App\Models\Post', 'myrecipe__colection_id');
    }

    public function getMyrecipe($id) {
        $myrecipe = Myrecipe_colection::where('id', $id)->with('image', 'movie')->first();

        return $myrecipe;
    }
    
    public function getMyrecipes($keyword, $value) {
        $user_id = Auth::id();
        $postRecipes = Myrecipe_colection::with('posts')
        ->whereHas('posts', function($q) {
            $q->whereExists(function ($q) {
                return $q;
            });
        });
        $postRecipes_id = $postRecipes->pluck('id');
        $mybookmarks_id = Bookmark::where('user_id', $user_id)->pluck('post_id');
        $myBookmarkRecipe_id = Post::whereIn('id', $mybookmarks_id)->pluck('myrecipe__colection_id');
        
        if($value == 'myrecipe') {
            $myrecipes = Myrecipe_colection::whereNotIn('id', $postRecipes_id)
            ->where('user_id', $user_id)
            ->where(function($q) use($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
            });
        }
        
        if($value == 'post') {
            $myrecipes = $postRecipes->where('user_id', $user_id)
            ->where(function($q) use($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
            });
        }
        
        if($value == 'bookmark') {
            $myrecipes = Myrecipe__colection::whereIn('id', $myBookmarkRecipe_id)
            ->where(function($q) use($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
            });
        }
        
        return $myrecipes;
    }

    public function getShowMyrecipes($recipe_id) {
        $myrecipe = Myrecipe_Colection::where('id', $recipe_id)->with('image', 'movie')->first();

        if($myrecipe->posts()->exists()) {
            foreach($myrecipe->posts as $post)
            $ranking = new RankingService;
            $ranking->incrementViewRanking($post->id);
            
            if($post->reports()->exists()) {
                $post = Post::withCount('bookmarks', 'reports')->find($post->id);
                $reports = Report::where('post_id', $post->id)->latest()->get();
                $param = [
                    'myrecipe' => $myrecipe,
                    'post' => $post,
                    'reports' => $reports,
                ];
            }else {
                $post = Post::withCount('bookmarks')->find($post->id);
                $param = [
                    'myrecipe' => $myrecipe,
                    'post' => $post,
                ];
            }
        }else {
            $param = [
		        'myrecipe' => $myrecipe,
            ];
        }

        return $param;
    }
    
}