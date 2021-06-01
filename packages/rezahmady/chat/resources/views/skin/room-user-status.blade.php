<div class="chat-header-user">
    <style>
        .timer{
            display:flex;
            direction: ltr;
            justify-content: flex-end;
        }
        .timer span + span:before{
            content:":"
        }
        .timer span {
            color: aqua;
        }
    </style>
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
        <small class="text-muted timer d-flex"  x-data="timerCounterDown()" x-init="init();">
            {{-- <span x-text="time().days"></span>
            <span x-text="time().hours"></span> --}}
            <span x-text="time().minutes"></span>
            <span x-text="time().seconds"></span>
        </small>
    </div>
    
    
</div>
