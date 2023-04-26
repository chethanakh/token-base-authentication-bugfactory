<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::all();
        return response($post, 200);
    }

    public function create(Request $request)
    {
        try {
            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->author = $request->author;
            $post->save();

            return response($post, 200);
        } catch (\Throwable $th) {
            return response($th->getTrace(), $th->getCode());
        }
    }
}
