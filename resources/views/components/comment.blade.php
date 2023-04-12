<div id="{{ $comment->id }}" class="comment">
    <div>
        <h4>{{ $comment->user->email }}</h4>
    </div>
    <div>
        <p class="text">{{ $comment->text }}</p>
    </div>
    <p class="comment-msg"></p>
    @if($comment->user_id == Auth::user()->id)
        <div>
            <button class="comment-edit-btn">Edit</button>
            <button class="comment-delete-btn">Delete</button>
        </div>
    @endif
</div>
