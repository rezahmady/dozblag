<div class="sidebar-body">
    <ul class="list-group list-group-flush">
        @foreach ($rooms as $room)
        <x-room-list-item :room="$room" :key="$room->id" />
        {{-- <livewire:chat.room-list-item :room="$room" :key="$room->id" /> --}}
        @endforeach
        {{-- <li class="list-group-item open-chat">
            <div>
                <figure class="avatar">
                    <img src="/packages/chatino/media/img/man_avatar3.jpg" class="rounded-circle">
                </figure>
            </div>
            <div class="users-list-body">
                <h5>طاهر نصیری</h5>
                <p>اختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.</p>
                <div class="users-list-action action-toggle">
                    <div class="dropdown">
                        <a data-toggle="dropdown" href="#">
                            <i class="ti-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item">باز</a>
                            <a href="#" data-navigation-target="contact-information" class="dropdown-item">پروفایل</a>
                            <a href="#" class="dropdown-item">اضافه کردن به بایگانی</a>
                            <a href="#" class="dropdown-item">حذف</a>
                        </div>
                    </div>
                </div>
            </div>
        </li> --}}
    </ul>
</div>