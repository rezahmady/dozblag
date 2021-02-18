<li>
    <div class="comment" id="comment_{{$comment->id}}">
        <div class="comment-author">
            <img class="avatar" alt="" src="{{url('assets/garrin/img/user.svg')}}">
        </div>
        <div class="comment-block">
            <span class="comment-by">
                <span class="blog-author-name">{{ $comment->name }}</span>
            </span>
            <p>{{ $comment->body }}</p>
            <p class="blog-date">6 مهر 1399</p>
            <a wire:click.prevent="$emit('setCommentParentId',{{$comment->id}})" class="comment-btn" href="#">
                <i class="fas fa-reply"></i> پاسخ
            </a>
        </div>
    </div>
    @if ($comment->childrenRecursive->count())
        @php
            $comments = $comment->childrenRecursive
        @endphp
        <ul class="comments-list reply">
            @foreach ($comments as $comment)
            <livewire:partials.comment.comment :comment="$comment" :key="$loop->index" :view="'theme::partials.comment.blog-comment'" />
            @endforeach
        </ul>
    @endif
</li>