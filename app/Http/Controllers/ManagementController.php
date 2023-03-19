<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ManagementController extends Controller
{
    public function index(User $user, Request $request)
    {
        $keyword = $request->input('keyword');
        $items = $user->getIndexUser($keyword, $user)->latest()->paginate(10);
        $param = [
            'items' => $items,
            'keyword' =>$keyword,
        ];

        return view('managements.manage', $param);
    }

    public function showUser(User $user, Request $request)
    {
        $user_id = $request->user_id;
        list($item, $posts) = $user->getShowUser($user_id);
        $posts->latest()->paginate(5);
        
        $param = [
            'item' => $item,
            'posts' => $posts,
        ];
        
        return view('managements.user_info', $param);
    }

    public function userDelete(User $user, Request $request)
    {
        $user_id = $request->user_id;
        $user->getUser($user_id)->delete();
        return redirect()->route('managements.manage');
    }

    public function showPost(User $user, Request $request)
    {
        $post_id = $request->post_id;
        $post = $user->getShowPost($post_id);
        return view('managements.user_post', ['post' => $post]);
    }

    public function postDelete(User $user, Request $request)
    {
        $post_id = $request->post_id;
        $post = $user->getShowPost($post_id)->delete();
        return redirect()->route('managements.manage');
    }
}
