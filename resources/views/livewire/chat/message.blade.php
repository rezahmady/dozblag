<div class="message-item {{$class}}">
    <div class="message-content">
        {!! $message->body !!}
    </div>
    <div class="message-action">
        {{$message->date}} <i class="ti-double-check"></i>
    </div>
</div>