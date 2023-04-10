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
    public function createPost (Request $request)
    {
        $fields = $request->only('title', 'text');
        $validator = Validator::make( $fields, [
            'title' => 'required|min:3',
            'text' => 'required|min:1'
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return back()->withErrors(['error' => $validator->errors()->first()]);
        }
        Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'text' => $request->text,
        ]);
        return redirect('posts');
    }
    public function editPostShow ($id)
    {
        $post = Post::find($id);
        if (Auth::user()->id == $post->user_id) {
            return view('post-edit')->with(['post' => $post]);
        } else {
            return back();
        }
    }
    public function editPost ($id, Request $request)
    {
        $fields = $request->only('title', 'text');
        $validator = Validator::make( $fields, [
            'title' => 'required|min:3',
            'text' => 'required|min:1'
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return back()->withErrors(['error' => $validator->errors()->first()]);
        }
        Post::find($id)->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);
        return redirect('posts');
    }
    public function deletePost ($id)
    {
        $post = Post::find($id);
        if (Auth::user()->id == $post->user_id) {
           $post->delete();
            return redirect('/posts');
        } else {
            return back();
        }
    }
}
