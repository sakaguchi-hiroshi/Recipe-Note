<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Myrecipe_Colection;

class ManagementController extends Controller
{
    public function index(User $user, Request $request)
    {
        $items = $user->getUserAll();
        $keyword = $request->input('keyword');
        if($keyword) {
            $items = $user->getSearchUser($keyword);
        }
        $param = [
            'items' => $items,
            'keyword' =>$keyword,
        ];
        return view('managements.manage', $param);
    }

    public function showUser(Request $request)
    {
        $item = User::find($request->user_id);
        $posts = Post::where('user_id', $item->id)->latest()->paginate(5);
        $param = [
            'item' => $item,
            'posts' => $posts,
        ];
        return view('managements.user_info', $param);
    }

    public function userDelete(Request $request)
    {
        $user_id = $request->user_id;
        User::find($user_id)->delete();
        return redirect()->route('managements.manage');
    }

    public function showPost(Request $request)
    {
        $post_id = $request->post_id;
        $post = Post::find($post_id);
        return view('managements.user_post', ['post' => $post]);
    }

    public function postDelete(Request $request)
    {
        $post_id = $request->post_id;
        Post::find($post_id)->delete();
        return redirect()->route('managements.manage');
    }
}
