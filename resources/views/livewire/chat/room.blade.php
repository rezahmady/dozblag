    <div class="chat-header" x-data="data()" x-init="hiddenLoader()">
        <livewire:chat.room-user-status :room="$room" :audience="$audience" :onlineUsers="$onlineUsers" :key="'room-user-status'.$audience->id" />
        <div class="chat-header-action">
            <ul class="list-inline">
                @if ($status != 'suggest')
                <li class="list-inline-item">
                    <a href="#" class="" data-toggle="dropdown">
                        <i class="ti-more"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">پروفایل</a>
                        @if ($room->status === 'archive')
                        <a wire:click.prevent="cancelArchive()" href="#" class="dropdown-item">خارج کردن از بایگانی</a>
                        @else
                        <a wire:click.prevent="archiveChat()" href="#" class="dropdown-item">اضافه کردن به بایگانی</a>
                        @endif
                        <a href="{{ url("/admin/room/$room->id/edit?iframe=true") }}" data-lity  class="dropdown-item">ویرایش و انتقال گفتگو</a>
                        <div class="dropdown-divider"></div>
                        <a wire:click.prevent="cancelChat()" href="#" class="dropdown-item">انصراف از پذیرش</a>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <x-chat-messages :room="$room" :audience="$audience" />
    
    <livewire:chat.create-message :room="$room" />



