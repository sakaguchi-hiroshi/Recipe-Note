<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Myrecipe_Colection;

class ManagementController extends Controller
{
    public function index(Request $request)
    {
        return view('managements.manage');
    }
    
    public function getMore(Request $request)
    {
        $indicateContent = $request->indicate_content;
        
        if($indicateContent == 'user') {
            $items = User::get();
        }
        
        if($indicateContent == 'post') {
            $items = Post::latest()->get();
        }

        $param = [
            'indicateContent' => $indicateContent,
            'items' => $items,
        ];

        return response()->json([
            'list' => view('managements.manage_ajax', $param)->render()
        ]);
    }
}
