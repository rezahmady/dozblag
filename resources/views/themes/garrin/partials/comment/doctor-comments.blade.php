<div class="widget review-listing">

    @if (sizeOf($comments))
    <ul class="comments-list">        
        @foreach ($comments as $comment) 
        <!-- Comment List -->
        <livewire:comment.comment :comment="$comment" :key="'comment-component-'.$loop->index" :view="'theme::partials.comment.doctor-comment'" />
        <!-- /Comment List -->
        @endforeach
    </ul>
    <!-- Show All -->
    @if ($hasMore)
    <div class="text-center all-feedback">
        <a wire:click.prevent="moreComments()" class="btn btn-primary btn-sm">
            مشاهده نظرات بیشتر
        </a>
    </div>
    @endif
    <!-- /Show All -->
    @else
    <p class="no-comments">هنوز نظری برای این پزشک ثبت نشده است</p>
    @endif
    

    <script>
        window.addEventListener('scrollTo', event => {
            location.href = '#'+event.detail.hash;
        })
    </script>
</div>