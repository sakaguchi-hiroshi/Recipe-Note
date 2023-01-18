<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Myrecipe_Colection;
use App\Models\Post;

class PostController extends Controller
{

    public function index(Post $post, $value)
    {
        $posts_id = Post::latest()->pluck('myrecipe__colection_id');
        $posts = Myrecipe_Colection::whereIn('id', $posts_id)->with('image', 'movie')->get();
        $params = [
            'posts' => $posts,
            'value' => $value,
        ];
        return view('posts.post', $params);
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
            return view('posts.order', ['posts' => $posts]);
        }
    }
}
