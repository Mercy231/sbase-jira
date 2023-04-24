<div id="{{ $post->id }}" class="post">
    <div>
        <h3>{{ $post->user->email }}</h3>
        @if(Cache::has('is_online' . $post->user->id))
            <p>Online</p>
        @else
            <p>Last seen {{ \Carbon\Carbon::parse($post->user->last_seen)->diffForHumans() }}</p>
        @endif
        <h2 class="title">{{ $post->title }}</h2>
    </div>
    <div>
        <p class="text">{{ $post->text }}</p>
    </div>
    <div>
        @if($post->user_id == Auth::user()->id)
            <button class="post-edit-btn">{{ __('messages.edit') }}</button>
            <button class="post-delete-btn">{{ __('messages.delete') }}</button>
        @endif
        <p class="post-msg"></p>
        <hr>
        <div class="comment-create">
            <h4>{{ __('messages.create_comment_title') }}</h4>
            <textarea class="comment-text" name="text"></textarea>
            <button class="comment-create-btn" type="submit">{{ __('messages.create') }}</button>
            <h5 class="comment-create-msg"></h5>
        </div>
        <div id="comments" class="comments">
            @foreach($post->comment as $comment)
                @include('components.comment')
            @endforeach
        </div>
    </div>
</div>
