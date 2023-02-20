<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Myrecipe_Colection;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function bookmark(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;
        $already_liked = Bookmark::where('user_id', $user_id)->where('post_id', $post_id)->first();

        if(!$already_liked) {
            Bookmark::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
            ]);
        }else {
            Bookmark::where('post_id', $post_id)->where('user_id', $user_id)->delete();
        }
        $post_likes_count = Post::withCount('bookmarks')->find($post_id)->bookmarks_count;
        $param = [
            'post_likes_count' => $post_likes_count,
        ];
        return response()->json($param);
    }
}
