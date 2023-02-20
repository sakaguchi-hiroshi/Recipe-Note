<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Myrecipe_Colection;
use App\Models\Post;

class RecipeNoteController extends Controller
{
    public function index()
    {
        $randomPosts_id = Post::select('myrecipe__colection_id')->inRandomOrder()->take(5)->get();
        $posts = Myrecipe_colection::whereIn('id', $randomPosts_id)->get();
        return view('recipenotes.index', ['posts' => $posts]);
    }

    public function showPremiumService()
    {
        return view('recipenotes.service');
    }
}