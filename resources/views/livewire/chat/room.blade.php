    <div class="chat-header" x-data="data()" x-init="hiddenLoader()">
        <livewire:chat.room-user-status :room="$room" :audience="$audience" :onlineUsers="$onlineUsers" :key="'room-user-status'.$audience->id" />
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
    <x-chat-messages :room="$room" :audience="$audience" />
    
    <livewire:chat.create-message :room="$room" />



