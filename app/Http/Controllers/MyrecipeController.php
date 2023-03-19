<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MyrecipeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Myrecipe_Colection;
use Illuminate\Support\Facades\Storage;

class MyrecipeController extends Controller
{
    public function index(Myrecipe_colection $myrecipe_colection, Request $request, $value)
    {
        $keyword = $request->input('keyword');
        $myrecipes = $myrecipe_colection->getMyrecipes($keyword, $value)->latest()->paginate(5);
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
        $user_id = $request->user_id;
        $title = $request->title;
        $image = $request->file('image');
        $movie = $request->file('movie');

        if(!empty($image)) {
            $upload_image = Storage::disk('s3')->putFile('/images', $image, 'public');
            $img_path = Storage::disk('s3')->url($upload_image);
            
            $image_id = Image::create([
                'user_id' => $user_id,
                'name' => $title,
                'path' => $img_path,
            ])->id;
        } else {
            $image_id = null;
	}

	if(!empty($movie)) {
            $upload_movie = Storage::disk('s3')->putFile('/movies', $movie, 'public');
            $movie_path = Storage::disk('s3')->url($upload_movie);

            $movie_id = Movie::create([
                'user_id' => $user_id,
                'name' => $title,
                'path' => $movie_path,
            ])->id;
        } else {
            $movie_id = null;
        }

        Myrecipe_Colection::create([
            'user_id' => $request->user_id,
            'image_id' => $image_id,
            'movie_id' => $movie_id,
            'title' => $title,
            'recipe' => $request->recipe,
            'url' => $request->url,
        ]);
        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }

    public function imageDelete(Request $request)
    {
	    $image = basename($request->image_path);
        Storage::disk('s3')->delete('images/'.$image);
        Image::find($request->image_id)->delete();

        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }

    public function movieDelete(Request $request)
    {
	    $movie = basename($request->movie_path);
        Storage::disk('s3')->delete('movies/'.$movie);
        Movie::find($request->movie_id)->delete();

        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }

    public function show(Myrecipe_colection $myrecipe_colection, Request $request)
    {
        $user_id = Auth::id();
        $recipe_id = $request->recipe_id;
        $param = $myrecipe_colection->getShowMyrecipes($recipe_id);

        return view('myrecipes.show', $param);
    }

    public function delete(Myrecipe_colection $myrecipe_colection, Request $request)
    {
        $id = $request->recipe_id;
        $myrecipe = $myrecipe_colection->getMyrecipe($id);
        if($myrecipe->image) {
                $image = basename($myrecipe->image->path);
                Storage::disk('s3')->delete('images/'.$image);
                $myrecipe->image->delete();
        }

        if($myrecipe->movie) {
                $movie = basename($myrecipe->movie->path);
                Storage::disk('s3')->delete('movies/'.$movie);
                $myrecipe->movie->delete();
        }

        $myrecipe->delete();
        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }
    
    public function edit(Myrecipe_colection $myrecipe_colection, Request $request)
    {
        if($request->old()) {
            $id = $request->old('recipe_id');
            $myrecipe = $myrecipe_colection->getMyrecipe($id);
            return view('myrecipes.edit', ['myrecipe' => $myrecipe]);
        }elseif($request->recipe_id) {
            $id = $request->recipe_id;
            $myrecipe = $myrecipe_colection->getMyrecipe($id);
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
                Storage::disk('s3')->delete('images/'.$old_image_path);
                $image = Storage::disk('s3')->putFile('/images', $request->file('image'), 'public');
                $image_path = Storage::disk('s3')->url($image);
                $update_image = Image::find($request->old_image_id)->update([
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
                Storage::disk('s3')->delete('movies/'.$old_movie_path);
                $movie = Storage::disk('s3')->putFile('/movies', $request->file('movie'), 'public');
                $movie_path = Storage::disk('s3')->url($movie);
                $update_movie = Movie::find($request->old_movie_id)->update([
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
