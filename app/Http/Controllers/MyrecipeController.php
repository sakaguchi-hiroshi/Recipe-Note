<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MyrecipeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
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
    public function index(Myrecipe_colection $myrecipe_colection, Request $request, $value)
    {
        $user_id = Auth::id();
        $keyword = $request->input('keyword');
        $postRecipes = $myrecipe_colection->with('posts')
        ->whereHas('posts', function($q) {
                $q->whereExists(function ($q) {
                    return $q;
                });
        });
        $postRecipes_id = $postRecipes->pluck('id');
        $mybookmarks_id = Bookmark::where('user_id', $user_id)->pluck('post_id');
        $myBookmarkRecipe_id = Post::whereIn('id', $mybookmarks_id)->pluck('myrecipe__colection_id');

        if($value == 'myrecipe') {
            $myrecipes = $myrecipe_colection->whereNotIn('id', $postRecipes_id)
            ->where('user_id', $user_id)
            ->where(function($q) use($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
            })->latest()->paginate(5);
        }

        if($value == 'post') {
            $myrecipes = $postRecipes->where('user_id', $user_id)
            ->where(function($q) use($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
            })->latest()->paginate(5);
        }

        if($value == 'bookmark') {
            $myrecipes = $myrecipe_colection->whereIn('id', $myBookmarkRecipe_id)
            ->where(function($q) use($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('recipe', 'LIKE', '%' . $keyword . '%');
            })->latest()->paginate(5);
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
	    $upload_image = Storage::disk('s3')->putFile('/images', $request->file('image'), 'public');
	    $img_path = Storage::disk('s3')->url($upload_image);
            
            $image_id = Image::create([
                'user_id' => $request->user_id,
                'name' => $request->title,
                'path' => $img_path,
            ])->id;
        } else {
            $image_id = null;
        }

        if(isset($request->movie)) {
	    $upload_movie = Storage::disk('s3')->putFile('/movies', $request->file('movie'), 'public');
	    $movie_path = Storage::disk('s3')->url($upload_movie);
            
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
	$image = basename($request->image_path);
        Storage::disk('s3')->delete('/images', $image);
        Image::find($request->image_id)->delete();

        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }

    public function movieDelete(Request $request)
    {
	$movie = basename($request->movie_path);
        Storage::disk('s3')->delete('movies', $movie);
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
        return view('myrecipes.show', $param);
    }

    public function delete(Request $request)
    {
        $myrecipe = Myrecipe_Colection::where('id', $request->recipe_id)->first();
	if($myrecipe->image) {
            $image = basename($myrecipe->image->path);
            Storage::disk('s3')->delete('/images', $image);
            $myrecipe->image->delete();
        }
	if($myrecipe->movie) {
	    $movie = basename($myrecipe->movie->path);
            Storage::disk('s3')->delete('/movies', $movie);
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
                $image_id = null;
            }
        }
        
        if(isset($request->image)) {
	    if(isset($request->old_image_id)) {
                $old_image_path = basename($request->old_image_path);
                Storage::disk('s3')->delete('/images', $old_image_path);
		$image = Storage::disk('s3')->putFile('/images', $request->file('image'), 'public');
                $image_path = Storage::disk('s3')->url($image);
                $old_image = Image::find($request->old_image_id)->update([
                    'name' => $request->title,
                    'path' => $image_path,
                ]);
                $image_id = Image::where('id', $request->old_image_id)->value('id');

	    }else {
		$image = Storage::disk('s3')->putFile('/images', $request->file('image'), 'public');
                $image_path = Storage::disk('s3')->url($image);
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
		$old_movie_path = basename($request->old_movie_path);
                Storage::disk('s3')->delete('/movies', $old_movie_path);
                $movie = Storage::disk('s3')->putFile('/movies', $request->file('movie'), 'public');
                $movie_path = Storage::disk('s3')->url($movie);
                $old_movie = Movie::find($request->old_movie_id)->update([
                    'name' => $request->title,
                    'path' => $movie_path,
                ]);
                $movie_id = Movie::where('id', $request->old_movie_id)->value('id');
            }else {
                $movie = Storage::disk('s3')->putFile('/movies', $request->file('movie'), 'public');
                $movie_path = Storage::disk('s3')->url($movie);
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
