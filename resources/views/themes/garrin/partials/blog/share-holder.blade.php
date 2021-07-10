<ul class="social-share {{$class}}">
    <li><a href="#" wire:click.prevent="like()" class="@if(session()->has("post.{$post->id}.like")) active @endif" title="می پسندم"><i class="fa fa-thumbs-up"></i><span class="social-value">
    {{$like}}    
    </span></a></li>
    <li><a href="#" wire:click.prevent="dislike()" class="@if(session()->has("post.{$post->id}.dislike")) active @endif" title="نمی پسندم"><i class="fa fa-thumbs-down"></i><span class="social-value">
    {{$dislike}} 
    </span></a></li>
    <li><a href="#blog-comments" title="نظرات"><i class="far fa-comments"></i><span class="social-value">
    {{$comment}}
    </span></a></li>
    <li><a wire:click="whatsapp()" href="whatsapp://send?text={{$post->whatsappContent}}" data-action="share/whatsapp" title="اشتراک گزاری در واتساپ"><i class="fab fa-whatsapp"></i><span class="social-value">
    {{$whatsapp}}  
    </span></a></li>
    <li><a wire:click="telegram()" href="https://t.me/iv?url={{ $post->path() }}&rhash=a702ddb0e6dcd" title="اشتراک گزاری در تلگرام"><i class="fab fa-telegram"></i><span class="social-value">
    {{$telegram}}  
    </span></a></li>

    
</ul>