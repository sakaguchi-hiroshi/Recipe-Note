<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\Report;

class ReportController extends Controller
{
    public function showform(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;
        $param = [
            'user_id' => $user_id,
            'post_id' => $post_id,
        ];
        return view('reports.form', $param);
    }

    public function add(ReportRequest $request)
    {
        if($request->image) {
            $image = Storage::disk('s3')->putFile('/images', $request->file('image'), 'public');
            $img_path = Storage::disk('s3')->url($image);
            
            $image_id = Image::create([
                'user_id' => $request->user_id,
                'name' => $request->coment,
                'path' => $img_path,
            ])->id;
        } else {
            $image_id = null;
        }

        Report::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'image_id' => $image_id,
            'coment' => $request->coment,
        ]);
        return redirect(route('myrecipes.myrecipe', ['value' => 'myrecipe']));
    }
}
