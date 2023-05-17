<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();

        if (!$posts) return response([
            'success' => true,
            'message' => 'Data Not Found',
            'data' => ''
        ], 404);

        return response([
            'success' => true,
            'message' => 'List Semua Materi',
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response([
                'success'=> true,
                'message' => 'Error Validation',
                'data' => $validator->errors()
            ], 400);
        }

        $data = Post::create([
            'title' => $input['title'],
            'content' => $input['content'],
            'slug' => Str::slug($input['title']),
        ]);

        return response([
            'success'=> true,
            'message' =>'Materi Berhasil Ditambahkan',
            'data' => $data
        ], 201);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if (!$post) return response([
            'success' => true,
            'message' => 'Data Not Found',
            'data' => ''
        ], 404);

        return response([
            'success' => true,
            'message' => 'Materi ditemukan',
            'data' => $post
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)->first();
        if (!$post) return response([
            'success' => true,
            'message' => 'Data not found',
            'data' => ''
        ], 404);

        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response([
                'success'=> true,
                'message' => 'Error Validation',
                'data' => $validator->errors()
            ], 400);
        }

        $post->update($input);

        $data = Post::find($id);

        return response([
            'success'=> true,
            'message' => 'Materi Berhasil Diubah',
            'data' => $data
        ], 201);
    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();
        if (!$post) return response([
            'success' => true,
            'message' => 'Data not found',
            'data' => ''
        ], 404);

        $post->delete();

        return response([
            'success'=> true,
            'message' => 'Materi Berhasil Dihapus',
        ], 201);
    }
}
