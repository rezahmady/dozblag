<div class="chat-header-user">
    <figure class="avatar avatar-md @if ($status)  avatar-state-success @endif">
        <img src="{{$audience->getProfile()}}" class="rounded-circle">
    </figure>
    <div>
        <h5>{{$audience->name}}</h5>
        <small class="text-muted">
            @php
                $text = ($status) ? 'آنلاین' : 'آفلاین';
            @endphp
            <i>{{$text}}</i>
        </small>
    </div>
    
</div>
