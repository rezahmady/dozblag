<li>
    <div class="p-3 comment card" id="comment_{{$comment->id}}">
        <div class="comment-body">
            <div class="meta-data">
                @php
                    $name = ($user) ? $user->name : $comment->name;

                    if($user) {
                        $profile = $user->getProfile();
                    } else {
                        $profile = url('assets/garrin/img/user.svg');
                    }

                @endphp
                <img class="avatar avatar-sm rounded-circle comment-avatar" alt="User Image" src="{{$profile}}">
                <div class="inline-block">
                    <span class="comment-author">{{ $name }}</span>
                    <span class="comment-date">{{$comment->date()}}</span>
                </div>
                <div class="review-count rating">
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <p class="comment-content">
                {{ $comment->body }}
            </p>

        </div>
    </div>
</li>