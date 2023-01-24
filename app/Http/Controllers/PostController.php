<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Myrecipe_Colection;
use App\Models\Post;
use App\Services\RankingService;

class PostController extends Controller
{

    public function index(Post $post, $value)
    {
        if($value == 'post') {
            $posts = $post->latest()->get();
        }

        if($value == 'movie') {
            $posts = $post->with('myrecipe_colection.movie')
            ->whereHas('myrecipe_colection.movie', function($q) {
                $q->whereExists(function($q){
                    return $q;
                });
            })->get();
        }
        $param = [
            'posts' => $posts,
            'value' => $value,
        ];
        return view('posts.post', $param);
    }

    public function confirm(Request $request)
    {
        if ($request->old()) {
            $myrecipe = Myrecipe_Colection::where('id', $request->old('recipe_id'))->with('image', 'movie')->first();
            return view('posts.confirm', ['myrecipe' => $myrecipe]);
        }elseif($request->recipe_id) {
            $myrecipe = Myrecipe_Colection::where('id', $request->recipe_id)->with('image', 'movie')->first();
            return view('posts.confirm', ['myrecipe' => $myrecipe]);
        }else {
            return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
        }
    }

    public function add(PostRequest $request)
    {
        $user_id = Auth::id();
        Post::create([
            'user_id' => $user_id,
            'myrecipe__colection_id' => $request->recipe_id,
        ]);
        return redirect(route('myrecipes.myrecipe', ['value' => 'post']));

    }

    public function delete(Request $request)
    {
        Post::where('myrecipe__colection_id', $request->recipe_id)->delete();
        return redirect(route('myrecipes.myrecipe', ['value' => 'post']));
    }

    public function showMovie()
    {
        $posts_id = Post::get('myrecipe__colection_id');
        $posts = Myrecipe_Colection::whereIn('id', $posts_id)->with('image')->latest()->get();
        return view('posts.post', ['posts' => $posts]);
    }

    public function showBookmarkOrder(Post $post)
    {
        if(isset($post)){
            $posts = $post->withCount('bookmarks')->orderBy('bookmarks_count', 'desc')->paginate(5);
            return view('posts.orders.bookmark', ['posts' => $posts]);
        }
    }

    public function showAccessOrder(Post $post)
    {
        $ranking = new RankingService;
        $results = $ranking->getRankingAll();
        $post_recipe_rankings = $post->getPostRecipeRanking($results);
        return view('posts.orders.access', ['post_recipe_rankings' => $post_recipe_rankings]);
    }
}
