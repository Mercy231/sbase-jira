<div id="{{ $post->id }}" class="post">
    <div>
        <h3>{{ $post->user->email }}</h3>
        @if(session()->get('locale') == 'ru')
            <h2 class="title">{{ $post->title_ru }}</h2>
        @else
            <h2 class="title">{{ $post->title }}</h2>
        @endif
    </div>
    <div>
        @if(session()->get('locale') == 'ru')
            <p class="text">{{ $post->text_ru }}</p>
        @else
            <p class="text">{{ $post->text }}</p>
        @endif
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
