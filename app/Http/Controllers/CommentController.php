<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function create (Request $request)
    {
        $fields = $request->only('text');
        $validator = Validator::make( $fields, [
            'text' => 'required|min:1',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->first()]);
        }
        if ($request->reply) {
            $comment = Comment::create([
                'comment_id' => $request->id,
                'user_id' => Auth::user()->id,
                'text' => $request->text,
            ]);
        } else {
            $comment = Comment::create([
                'post_id' => $request->id,
                'user_id' => Auth::user()->id,
                'text' => $request->text,
            ]);
        }
        $html = view('components.comment')->with(['comment' => $comment])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
    public function update ($id, Request $request)
    {
        $fields = $request->only('text');
        $validator = Validator::make( $fields, [
            'text' => 'required|min:1',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->first()]);
        }
        $comment = Comment::find($id)->update([
            'text' => $request->text,
        ]);
        return response()->json(['success' => true, 'comment' => $comment]);
    }
    public function destroy ($id)
    {
        $comment = Comment::find($id);
        if (Auth::user()->id == $comment->user_id) {
            $comment->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
