<div id="{{ $comment->id }}" class="comment">
        <div>
            <h4>{{ $comment->user->email }}</h4>
            @if(Cache::has('is_online' . $comment->user->id))
                <p>Online</p>
            @else
                <p>Last seen {{ \Carbon\Carbon::parse($comment->user->last_seen)->diffForHumans()}}</p>
            @endif
        </div>
        <div>
            <p class="text">{{ $comment->text }}</p>
        </div>
        <p class="comment-msg"></p>
        @if($comment->user_id == Auth::user()->id)
            <div class="comment-footer">
                <div>
                    <button class="comment-edit-btn">Edit</button>
                    <button class="comment-delete-btn">Delete</button>
                </div>
            </div>
        @endif
    <hr>
    <div class="comment-create">
        <h4>{{ __('messages.create_reply_title') }}</h4>
        <textarea class="comment-text" name="text"></textarea>
        <button class="comment-reply-btn">Reply</button>
        <h5 class="comment-create-msg"></h5>
    </div>
    <div>
        <div id="comments" class="comments">
            @foreach($comment->comment as $comment)
                @include('components.comment')
            @endforeach
        </div>
    </div>
</div>
