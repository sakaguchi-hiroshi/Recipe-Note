<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MyrecipeRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Myrecipe_Colection;

class MyrecipeController extends Controller
{
    public function index($value)
    {
        if($value == 'myrecipe') {
            $user_id = Auth::id();
            $myrecipes = Myrecipe_colection::where('user_id', $user_id)->with('image', 'movie')->latest()->get();
        }
        
        if($value == 'bookmark') {
            $user_id = Auth::id();
            $myrecipes = Bookmark::where('user_id', $user_id)->with('image', 'movie')->latest()->get();
        }

        return view('myrecipes.myrecipe', ['myrecipes' => $myrecipes]);
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
            $img_path = $image->store('image', 'public');
            
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
            $movie_path = $movie->store('movie', 'public');
            
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

    public function show(Request $request)
    {
        $user_id = Auth::id();
        $myrecipe = Myrecipe_Colection::where('id', $request->recipe_id)->with('image', 'movie')->first();
        return view('myrecipes.show', ['myrecipe' => $myrecipe]);
    }
}
// dd($myrecipe);
