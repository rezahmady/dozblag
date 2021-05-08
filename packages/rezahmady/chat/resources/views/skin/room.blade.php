<div class="chat-header" >
    <livewire:chat.room-user-status :room="$room" :audience="$audience" :onlineUsers="$onlineUsers" :key="'room-user-status'.$audience->id" />
    <div class="chat-header-action">
        <ul class="list-inline">
            <li x-on:click="sidebarShow()" class="list-inline-item"><i class="ti-arrow-left"></i></li>
            @if ($status != 'suggest')
            <li class="list-inline-item">
                <a href="#" class="" data-toggle="dropdown">
                    <i class="ti-more"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" data-navigation-target="contact-information" class="dropdown-item">پروفایل</a>
                    @if (backpack_user()->hasTemplate(['operator', 'doctor']) )
                        @if ($room->status === 'archive')
                        <a wire:click.prevent="cancelArchive()" href="#" class="dropdown-item">خارج کردن از بایگانی</a>
                        @else
                        <a wire:click.prevent="archiveChat()" href="#" class="dropdown-item">اضافه کردن به بایگانی</a>
                        @endif
                    @endif
                    @if (backpack_user()->hasTemplate('operator'))
                    <a href="{{ url("/admin/room/$room->id/edit?iframe=true") }}" data-lity  class="dropdown-item">ویرایش و انتقال گفتگو</a>
                    <div class="dropdown-divider"></div>
                    <a wire:click.prevent="cancelChat()" href="#" class="dropdown-item">انصراف از پذیرش</a>
                    @endif
                </div>
            </li>
            @endif
        </ul>
    </div>
</div>
<x-chat-messages :room="$room" :audience="$audience" />

<livewire:chat.create-message :room="$room" :key="'chat-create-message'" />