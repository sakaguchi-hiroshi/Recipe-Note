<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MyrecipeRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Myrecipe_Colection;
use App\Models\Post;
use App\Models\Bookmark;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use App\Services\RankingService;

class MyrecipeController extends Controller
{
    public function index($value)
    {
        $user_id = Auth::id();

        
        
        if($value == 'myrecipe') {
            $myrecipes = Myrecipe_colection::where('user_id', $user_id)->with('image', 'movie')->with('posts')->latest()->get();
        }
        
        if($value == 'post') {
            $myPostRecipes = Post::select('myrecipe__colection_id')->where('user_id', $user_id)->get();
            $myrecipes = Myrecipe_Colection::whereIn('id', $myPostRecipes)->latest()->get();
        }

        if($value == 'bookmark') {
            $mybookmarks = Bookmark::select('post_id')->where('user_id', $user_id)->get();
            $myPostRecipes = Post::select('myrecipe__colection_id')->whereIn('id', $mybookmarks)->get();
            $myrecipes = Myrecipe_Colection::whereIn('id', $myPostRecipes)->latest()->get();
        }

        $params = [
            'myrecipes' => $myrecipes,
            'value' => $value,
        ];
        return view('myrecipes.myrecipe', $params);
    }

    public function showForm()
    {
        $user_id = Auth::id();
        return view('myrecipes.form', ['user_id' => $user_id]);
    }

    public function add(MyrecipeRequest $request)
    {
        if(isset($request->image)) {
            $image = $request->file('image');
            $img_path = $image->store('images', 'public');
            
            $image_id = Image::create([
                'user_id' => $request->user_id,
                'name' => $request->title,
                'path' => $img_path,
            ])->id;
        } else {
            $image_id = null;
        }

        if(isset($request->movie)) {
            $movie = $request->file('movie');
            $movie_path = $movie->store('movies', 'public');
            
            $movie_id = Movie::create([
                'user_id' => $request->user_id,
                'name' => $request->title,
                'path' => $movie_path,
            ])->id;
        } else {
            $movie_id = null;
        }
        
        Myrecipe_Colection::create([
            'user_id' => $request->user_id,
            'image_id' => $image_id,
            'movie_id' => $movie_id,
            'title' => $request->title,
            'recipe' => $request->recipe,
            'url' => $request->url,
        ]);
        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }

    public function imageDelete(Request $request)
    {
        \Storage::disk('public')->delete($request->image_path);
        Image::find($request->image_id)->delete();

        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }

    public function movieDelete(Request $request)
    {
        \Storage::disk('public')->delete($request->movie_path);
        Movie::find($request->movie_id)->delete();

        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }

    public function show(Request $request)
    {
        $user_id = Auth::id();
        $recipe_id = $request->recipe_id;
        $myrecipe = Myrecipe_Colection::where('id', $request->recipe_id)->with('image', 'movie')->first();

        if($myrecipe->posts()->exists()) {
            foreach($myrecipe->posts as $post)
            $ranking = new RankingService;
            $ranking->incrementViewRanking($post->id);
            
            if($post->reports()->exists()) {
                foreach($post->reports as $report)
                $post = Post::withCount('bookmarks', 'reports')->find($post->id);
                $param = [
                    'myrecipe' => $myrecipe,
                    'post' => $post,
                    'report' => $report,
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
        return view('myrecipes.show', $param);
    }

    public function delete(Request $request)
    {
        $myrecipe = Myrecipe_Colection::where('id', $request->recipe_id)->first();
        if($myrecipe->image) {
            \Storage::disk('public')->delete($myrecipe->image->path);
            $myrecipe->image->delete();
        }
        if($myrecipe->movie) {
            \Storage::disk('public')->delete($myrecipe->movie->path);
            $myrecipe->movie->delete();
        }
        $myrecipe->delete();
        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }
    
    public function edit(Request $request)
    {
        if($request->old()) {
            $myrecipe = Myrecipe_Colection::where('id', $request->old('recipe_id'))->with('image', 'movie')->first();
            return view('myrecipes.edit', ['myrecipe' => $myrecipe]);
        }elseif($request->recipe_id) {
            $myrecipe = Myrecipe_Colection::where('id', $request->recipe_id)->with('image', 'movie')->first();
            return view('myrecipes.edit', ['myrecipe' => $myrecipe]);
        }else {
            return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
        }
    }

    public function update(MyrecipeRequest $request)
    {
        $user_id = Auth::id();

        if(is_null($request->image)) {
            if(isset($request->old_image_id)) {
                $image_id = $request->old_image_id;
            }elseif(is_null($request->old_image_id)) {
                dd($request);
                $image_id = null;
            }
        }
        
        if(isset($request->image)) {
            if(isset($request->old_image_id)) {
                \Storage::disk('public')->delete($request->old_image_path);
                $image = $request->file('image');
                $image_path = $image->store('images', 'public');
                $old_image = Image::find($request->old_image_id)->update([
                    'name' => $request->title,
                    'path' => $image_path,
                ]);
                $image_id = Image::where('id', $request->old_image_id)->value('id');

            }else {
                $image = $request->file('image');
                $image_path = $image->store('images', 'public');
                $image_id = Image::create([
                    'user_id' => $user_id,
                    'name' => $request->title,
                    'path' => $image_path,
                ])->id;
            }
        }

        if(is_null($request->movie)) {
            if(isset($request->old_movie_id)) {
                $movie_id = $request->old_movie_id;
            }elseif(is_null($request->old_movie_id)) {
                $movie_id = null;
            }
        }
        
        if(isset($request->movie)) {
            if(isset($request->old_movie_id)) {
                \Storage::disk('public')->delete($request->old_movie_path);
                $movie = $request->file('movie');
                $movie_path = $movie->store('movies', 'public');
                $old_movie = Movie::find($request->old_movie_id)->update([
                    'name' => $request->title,
                    'path' => $movie_path,
                ]);
                $movie_id = Movie::where('id', $request->old_movie_id)->value('id');
            }else {
                $movie = $request->file('movie');
                $movie_path = $movie->store('movies', 'public');
                $movie_id = Movie::create([
                    'user_id' => $user_id,
                    'name' => $request->title,
                    'path' => $movie_path,
                ])->id;
            }
        }

        $myrecipe = Myrecipe_Colection::where('id', $request->recipe_id)->update([
            'user_id' => $user_id,
            'image_id' => $image_id,
            'movie_id' => $movie_id,
            'title' => $request->title,
            'recipe' => $request->recipe,
            'url' => $request->url,
        ]);

        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }
}
