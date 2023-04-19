<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function showPosts ()
    {
        return view('posts', ['posts' => Post::latest()->get()]);
    }
    public function create (Request $request)
    {
        $fields = $request->only('title', 'text', 'titleRu', 'textRu');
        $validator = Validator::make( $fields, [
            'title' => 'required|min:3',
            'text' => 'required|min:1',
            'titleRu' => 'required|min:3',
            'textRu' => 'required|min:1'
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->first()]);
        }

        $title = json_encode([
            'en' => $request->title,
            'ru' => $request->titleRu,
        ], JSON_UNESCAPED_UNICODE);
        $text = json_encode([
            'en' => $request->text,
            'ru' => $request->textRu,
        ], JSON_UNESCAPED_UNICODE);

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'title' => $title,
            'text' => $text,
        ]);
        $html = view('components.post')->with(['post' => $post])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
    public function update ($id, Request $request)
    {
        $fields = $request->only('title', 'text');
        $validator = Validator::make( $fields, [
            'title' => 'required|min:3',
            'text' => 'required|min:1'
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->first()]);
        }
        $post = Post::find($id)->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);
        return response()->json(['success' => true, 'post' => $post]);
    }
    public function destroy ($id)
    {
        $post = Post::find($id);
        if (Auth::user()->id == $post->user_id) {
           $post->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
