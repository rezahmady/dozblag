<li class='nav-item'><a target="_blank" class='nav-link' href='{{ url('/') }}'><i class='nav-icon la la-external-link'></i> نمایش وب سایت</a></li>
<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


@can('page list')
<!-- Pages -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-file"></i> مدیریت صفحات</a>
	<ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page') }}'><i class='nav-icon la la-file'></i> <span>همه صفحات</span></a></li>
        @can('page create text')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page/create?template=text') }}'><i class='nav-icon la la-align-right'></i> <span>ایجاد صفحه محتوایی</span></a></li>
        @endcan
        @can('page create shop')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page/create?template=shop') }}'><i class='nav-icon la la-shopping-cart'></i> <span>ایجاد دسته فروشگاهی</span></a></li>
        @endcan
        @can('page create blog')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page/create?template=blog') }}'><i class='nav-icon la la-file-text'></i> <span>ایجاد دسته وبلاگی</span></a></li>
        @endcan
        @can('page create gallery')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page/create?template=gallery') }}'><i class='nav-icon la la-image'></i> <span>ایجاد گالری تصاویر</span></a></li>
        @endcan
        @can('page create form')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page/create?template=form') }}'><i class='nav-icon la la-clipboard'></i> <span>ایجاد فرم</span></a></li>
        @endcan
        @can('page create link')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page/create?template=link') }}'><i class='nav-icon la la-link'></i> <span>ایجاد لینک</span></a></li>
        @endcan
	</ul>
</li>
@endcan


<!-- Products -->
@can('product manage')
{{-- <li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-shopping-bag la-lg"></i> فروشگاه</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class='la la-barcode la-lg'></i> محصولات</a></li>
        @can('filter list')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('filter') }}'><i class='nav-icon la la-sitemap'></i> دسته فیلتر</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('filteritem') }}'><i class='nav-icon la la-filter'></i> فیلترها</a></li>
        @endcan
    </ul>
</li> --}}
@endcan

@can('user manage')
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> مدیریت کاربران</a>
	<ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>{{ trans('backpack::permissionmanager.users') }}</span></a></li>
        @can('role manage')
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>{{ trans('backpack::permissionmanager.roles') }}</span></a></li>
        @endcan
        @can('permission manage')
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>{{ trans('backpack::permissionmanager.permission_plural') }}</span></a></li>
        @endcan
        @can('comment list')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user/doctor/comment') }}'><i class='nav-icon la la-comments'></i> کامنت پزشکان</a></li>
        @endcan
	</ul>
</li>
@endcan



@can('post manage')
<!-- Articles, Category, Tag -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-newspaper-o"></i>وبلاگ</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('article') }}"><i class="nav-icon la la-newspaper-o"></i> {{ trans('general.article_plural') }}</a></li>
        {{-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon la la-list"></i> {{ trans('general.category_singular') }}</a></li> --}}
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('tag') }}"><i class="nav-icon la la-tag"></i> {{ trans('general.tag_plural') }}</a></li>
        @can('comment list')
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('article/comment') }}'><i class='nav-icon la la-comments'></i> کامنت ها</a></li>
        @endcan
    </ul>
</li>
@endcan
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
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-paint-brush"></i> قالب</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('theme') }}'><i class='nav-icon la la-television'></i> انتخاب قالب</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('widget') }}'><i class='nav-icon la la-puzzle-piece'></i> ابزارک ها</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('menu') }}'><i class='nav-icon la la-reorder'></i> منو ها</a></li>
    </ul>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('message') }}'><i class='nav-icon la la-envelope-o'></i> صندوق پیام</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('room') }}'><i class='nav-icon la la-question'></i> Rooms</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('chat') }}'><i class='nav-icon la la-question'></i> Chats</a></li>