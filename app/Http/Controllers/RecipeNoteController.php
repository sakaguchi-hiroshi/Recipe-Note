<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecipeNoteController extends Controller
{
    public function index()
    {
        // $randomPosts = Post::inRandomOrder()->take(0,10)->get();
        // return view('index', ['randomPost' => $randomPost]);
        return view('index');
    }

    public function showPremiumService()
    {
        return view('service');
    }
}
