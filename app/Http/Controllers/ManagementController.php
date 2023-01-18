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
        $indicateContent = $request->indicate_content;
        
        if(empty($indicateContent)) {
            return view('managements.manage');
        }

        if($indicateContent == 'user') {
            $items = User::latest()->get();
        }
        
        if($indicateContent == 'post') {
            $items = Post::latest()->get();
        }
        $param = [
            'indicateContent' => $indicateContent,
            'items' => $items,
        ];
        return response()->json([
            'list' => view('managements.manage', $param)->render(),
        ]);
    }
}
