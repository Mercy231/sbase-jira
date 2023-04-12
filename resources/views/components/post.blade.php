<div id="{{ $post->id }}" class="post">
    <div>
        <h3>{{ $post->user->email }}</h3>
        <h2 class="title">{{ $post->title }}</h2>
    </div>
    <div>
        <p class="text">{{ $post->text }}</p>
    </div>
    <div>
        @if($post->user_id == Auth::user()->id)
            <button class="post-edit-btn">Edit</button>
            <button class="post-delete-btn">Delete</button>
        @endif
        <p class="post-msg"></p>
        <hr>
        <div class="comment-create">
            <h4>Create new comment</h4>
            <textarea class="comment-text" name="text"></textarea>
            <button class="comment-create-btn" type="submit">Create</button>
            <h5 class="comment-create-msg"></h5>
        </div>
        <div id="comments" class="comments">
            @foreach($post->comment as $comment)
                @include('components.comment')
            @endforeach
        </div>
    </div>
</div>
