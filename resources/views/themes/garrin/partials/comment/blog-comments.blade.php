<div class="container-fluid px-3">
    <div class="row" >
        <div class="col-md-7 blog-single-comments">
            
            <div class="blog-comments clearfix">
                @if (sizeOf($comments))
                <div class="pb-0">
                    <ul class="comments-list">
                        @foreach ($comments as $comment) 
                            <livewire:comment.comment :comment="$comment" :key="'comment-component-'.$loop->index" :view="'theme::partials.comment.blog-comment'" />
                        @endforeach
                    </ul>
                </div>
                @else
                <p class="no-comments">هنوز نظری برای این مقاله ثبت نشده است</p>
                @endif
                
            </div>
        </div>
        <div class="col-md-5 comment-create-box">
    
            <div class="new-comment clearfix sticky pt-3" id="create-comment">
                <div class="">
                    <h4 class="section-title">ارسال نظر</h4>
                </div>
                <div class="card-body">
                    <livewire:comment.create-comment :module="'Article'" :moduleId="$postId" :view="'theme::partials.comment.blog-create-comment'" />
                </div>
            </div>
        </div>
    </div>    

</div>

<script>
    window.addEventListener('scrollTo', event => {
        location.href = '#'+event.detail.hash;
    })
</script>