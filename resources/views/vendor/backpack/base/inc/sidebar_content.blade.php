
<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


<?php
use App\Services\Menu;
use TorMorten\Eventy\Facades\Events as Eventy;

$menu = Menu::create(function($menu) {
            Eventy::action('admin-menu-build', $menu);
        })->render();
?>

{!! $menu !!}

@can('admin advance')
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-cogs"></i> پیشرفته</a>
    <ul class="nav-dropdown-items">
        @can('admin filemanager')
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}\"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
        @endcan
        @can('admin backup')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i class='nav-icon la la-hdd-o'></i> پشتیبان گیری</a></li>
        @endcan
        @can('admin log')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon la la-terminal'></i> لاگ</a></li>
        @endcan
        @can('admin setting')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon la la-cog'></i> <span>تنظیمات </span></a></li>
        @endcan
    </ul>
</li>
@endcan

@can('admin message')
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('message') }}'><i class='nav-icon la la-envelope-o'></i> صندوق پیام</a></li>
@endcan
