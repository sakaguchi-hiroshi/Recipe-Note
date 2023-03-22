<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Myrecipe_Colection;
use App\Models\Post;
use App\Services\RankingService;

class PostController extends Controller
{

    public function index(Post $post, Request $request, $value)
    {
        $posts = $post->latest()->paginate(5);
        $keyword = $request->input('keyword');
        if($post) {
            $posts = $post->getIndexPosts($keyword, $value)->latest()->paginate(5);
        }
        $param = [
            'posts' => $posts,
            'value' => $value,
        ];
        return view('posts.post', $param);
    }

    public function confirm(Myrecipe_Colection $myrecipe_colection, Request $request)
    {
        if ($request->old()) {
            $id = $request->old('recipe_id');
            $myrecipe = $myrecipe_colection->getMyrecipe($id);
            return view('posts.confirm', ['myrecipe' => $myrecipe]);
        }elseif($request->recipe_id) {
            $id = $request->recipe_id;
            $myrecipe = $myrecipe_colection->getMyrecipe($id);
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

    public function delete(Post $post, Request $request)
    {
        $recipe_id = $request->recipe_id;
        $post->getPostRecipe($recipe_id)->delete();
        return redirect(route('myrecipes.myrecipe', ['value' => 'post']));
    }

    public function showBookmarkOrder(Request $request, Post $post)
    {
        if(Gate::denies('premium')) {
            return view('recipenotes.service');
        }
        if(isset($post)){
            $keyword = $request->input('keyword');
            $posts = $post->getBookmarkOrderPosts($keyword)->paginate(5);
            return view('posts.orders.bookmark', ['posts' => $posts]);
        }
    }

    public function showAccessOrder(Request $request, Post $post)
    {
        if(Gate::denies('premium')) {
            return view('recipenotes.service');
        }
        if(isset($post)) {
            $keyword = $request->input('keyword');
            $ranking = new RankingService;
            $results = $ranking->getRankingAll();
            $post_recipe_rankings = $post->getPostRecipeRanking($results, $keyword)->paginate(5);
            return view('posts.orders.access', ['post_recipe_rankings' => $post_recipe_rankings]);
        }
    }
}
