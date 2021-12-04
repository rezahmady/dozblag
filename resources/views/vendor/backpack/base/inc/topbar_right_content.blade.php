<!-- This file is used to store topbar (right) items -->
@php
    $message = App\Models\Message::where('status', 0)->count();
@endphp
@if ($message)
<li class="nav-item d-md-down-none"><a class="nav-link" href="{{ backpack_url('message') }}"><i class="la la-bell"></i><span class="badge badge-pill badge-danger">{{ $message }}</span></a></li>
@endif
{{--<button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show"><span class="navbar-toggler-icon"></span></button>--}}
@action('admin.topbar-right-content::action', false)
{{-- <li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-list"></i></a></li>
<li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-map"></i></a></li> --}}
