<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
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
        $comment = Comment::create([
            'comment_id' => $request->id,
            'user_id' => Auth::user()->id,
            'text' => $request->text,
        ]);
        $html = view('components.comment')->with(['comment' => $comment])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
}
