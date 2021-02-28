<div class="chat position-relative" >
    <div class="chat-header">
        <div class="chat-header-user">
            <figure class="avatar avatar-md">
                <img src="{{$audience->profile}}" class="rounded-circle">
            </figure>
            <div>
                <h5>{{$audience->name}}</h5>
                <small class="text-muted">
                    <i>آنلاین</i>
                </small>
            </div>

        </div>
        <div class="chat-header-action">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="#" class="">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" class="">
                        <i class="fa fa-video-camera" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" class="" data-toggle="dropdown">
                        <i class="ti-more"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">پروفایل</a>
                        <a href="#" class="dropdown-item">اضافه کردن به بایگانی</a>
                        <a href="#" class="dropdown-item">حذف</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">بلاک</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <livewire:chat.messages :room="$room" />
    
    <livewire:chat.create-message :room="$room" />

    <div x-show="loadingRoom" class="loading-holder">
        <div class="container p-3 empty-chat-holder" >
            <div  class="empty-chat-img loader-spiner-01"></div>
        </div>
    </div>
</div>

