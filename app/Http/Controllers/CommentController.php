<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function createCommentShow ($id)
    {
        return view('comment-create')->with(['id' => $id]);
    }
    public function createComment ($id, Request $request)
    {
        $fields = $request->only('text');
        $validator = Validator::make( $fields, [
            'text' => 'required|min:1',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return back()->withErrors(['error' => $validator->errors()->first()]);
        }
        Comment::create([
            'post_id' => $id,
            'user_id' => Auth::user()->id,
            'text' => $request->text,
        ]);
        return redirect('posts');
    }
    public function editCommentShow ($id)
    {
        $comment = Comment::find($id);
        if (Auth::user()->id == $comment->user_id) {
            return view('comment-edit')->with(['comment' => $comment]);
        } else {
            return back();
        }
    }
    public function editComment ($id, Request $request)
    {
        $fields = $request->only('text');
        $validator = Validator::make( $fields, [
            'text' => 'required|min:1',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return back()->withErrors(['error' => $validator->errors()->first()]);
        }
        Comment::find($id)->update([
            'text' => $request->text,
        ]);
        return redirect('posts');
    }
    public function deleteComment ($id)
    {
        $comment = Comment::find($id);
        if (Auth::user()->id == $comment->user_id) {
            $comment->delete();
            return redirect('/posts');
        } else {
            return back();
        }
    }
}
