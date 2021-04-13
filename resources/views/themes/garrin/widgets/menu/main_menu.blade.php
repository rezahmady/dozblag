<ul class="main-nav position-relative">
    @can('page update')
        <a class="btn btn-setting mb-5" x-on:click="setwidget('{{$widget->name}}')" style="top:-6px;left:-50px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#bnr") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
    @endcan

    @if ($widget->type == 'custom_menu')
        @php
            $items = json_decode(json_decode($widget->extras['data'])[0]->items);
        @endphp

        @foreach ($items as $item)
            <li class="nav-item"><a @isset($item->target) target="{{ $item->target }}" @endisset   @isset($item->link) href="{{ $item->link }}" @endisset  >@isset($item->label) {{ $item->label }} @endisset</a></li>
        @endforeach
    @else
        {!! $menu !!}
    @endif

</ul>


{{--<ul class="main-nav">--}}
{{--    <li class="active">--}}
{{--        <a href="index.html">خانه</a>--}}
{{--    </li>--}}
{{--    <li class="has-submenu">--}}
{{--        <a href="#">پزشک‌ها<i class="fas fa-chevron-down"></i></a>--}}
{{--        <ul class="submenu">--}}
{{--            <li><a href="doctor-dashboard.html">دشبرد پزشک</a></li>--}}
{{--            <li><a href="appointments.html">نوبت‌دهی</a></li>--}}
{{--            <li><a href="schedule-timings.html">زمان‌بندی</a></li>--}}
{{--            <li><a href="my-patients.html">لیست بیماران</a></li>--}}
{{--            <li><a href="patient-profile.html">پروفایل بیماران</a></li>--}}
{{--            <li><a href="chat-doctor.html">چت</a></li>--}}
{{--            <li><a href="invoices.html">صورت‌حساب</a></li>--}}
{{--            <li><a href="doctor-profile-settings.html">تنظیمات پروفایل</a></li>--}}
{{--            <li><a href="reviews.html">نظرات</a></li>--}}
{{--            <li><a href="doctor-register.html">ثبت‌نام پزشک</a></li>--}}
{{--            <li class="has-submenu">--}}
{{--                <a href="doctor-blog.html">بلاگ</a>--}}
{{--                <ul class="submenu">--}}
{{--                    <li><a href="doctor-blog.html">بلاگ</a></li>--}}
{{--                    <li><a href="blog-details.html">مشاهده بلاگ</a></li>--}}
{{--                    <li><a href="doctor-add-blog.html">افزودن بلاگ</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    <li class="has-submenu">--}}
{{--        <a href="#">مراجعه‌کنندگان<i class="fas fa-chevron-down"></i></a>--}}
{{--        <ul class="submenu">--}}
{{--            <li class="has-submenu">--}}
{{--                <a href="#">پزشکان</a>--}}
{{--                <ul class="submenu">--}}
{{--                    <li><a href="map-grid.html">گرید نقشه</a></li>--}}
{{--                    <li><a href="map-list.html">لیست نقشه</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li><a href="search.html">جستجو پزشک</a></li>--}}
{{--            <li><a href="doctor-profile.html">پروفایل پزشک</a></li>--}}
{{--            <li><a href="booking.html">رزرو نوبت</a></li>--}}
{{--            <li><a href="checkout.html">پرداخت</a></li>--}}
{{--            <li><a href="booking-success.html">رزرو موفق</a></li>--}}
{{--            <li><a href="patient-dashboard.html">دشبرد مراجعه‌کننده</a></li>--}}
{{--            <li><a href="favourites.html">‌علاقه‌مندیها</a></li>--}}
{{--            <li><a href="chat.html">چت</a></li>--}}
{{--            <li><a href="profile-settings.html">تنظیمات پروفایل</a></li>--}}
{{--            <li><a href="change-password.html">‌تغییر رمز عبور</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    <li class="has-submenu">--}}
{{--        <a href="#">‌داروخانه<i class="fas fa-chevron-down"></i></a>--}}
{{--        <ul class="submenu">--}}
{{--            <li><a href="pharmacy-index.html">‌داروخانه</a></li>--}}
{{--            <li><a href="pharmacy-details.html">‌جزییات داروخانه</a></li>--}}
{{--            <li><a href="pharmacy-search.html">‌جستجو داروخانه</a></li>--}}
{{--            <li><a href="product-all.html">‌محصولات</a></li>--}}
{{--            <li><a href="product-description.html">توضیحات محصول</a></li>--}}
{{--            <li><a href="cart.html">‌سبد خرید</a></li>--}}
{{--            <li><a href="product-checkout.html">‌خرید محصولات</a></li>--}}
{{--            <li><a href="payment-success.html">‌پرداخت موفق</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    <li class="has-submenu">--}}
{{--        <a href="#">‌صفحات<i class="fas fa-chevron-down"></i></a>--}}
{{--        <ul class="submenu">--}}
{{--            <li><a href="voice-call.html">‌تماس صوتی</a></li>--}}
{{--            <li><a href="video-call.html">‌تماس تصویری</a></li>--}}
{{--            <li><a href="search.html">‌جستجو پزشک</a></li>--}}
{{--            <li><a href="calendar.html">‌تقویم</a></li>--}}

{{--            <li><a href="components.html">‌کامپوننت‌ها</a></li>--}}
{{--            <li class="has-submenu">--}}
{{--                <a href="invoices.html">صورت‌حساب</a>--}}
{{--                <ul class="submenu">--}}
{{--                    <li><a href="invoices.html">صورت‌حساب</a></li>--}}
{{--                    <li><a href="invoice-view.html">‌مشاهده صورت‌حساب</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li><a href="blank-page.html">‌صفحه شروع</a></li>--}}
{{--            <li><a href="login.html">‌ورود</a></li>--}}
{{--            <li><a href="register.html">‌ثبت‌نام</a></li>--}}
{{--            <li><a href="forgot-password.html">‌فراموشی رمزعبور</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    <li class="has-submenu">--}}
{{--        <a href="#">‌بلاگ<i class="fas fa-chevron-down"></i></a>--}}
{{--        <ul class="submenu">--}}
{{--            <li><a href="blog-list.html">‌لیست بلاگ</a></li>--}}
{{--            <li><a href="blog-grid.html">‌گرید بلاگ</a></li>--}}
{{--            <li><a href="blog-details.html">‌جزییات بلاگ</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    <li class="has-submenu">--}}
{{--        <a href="#" target="_blank">ادمین<i class="fas fa-chevron-down"></i></a>--}}
{{--        <ul class="submenu">--}}
{{--            <li><a href="admin/index.html" target="_blank">‌ادمین</a></li>--}}
{{--            <li><a href="pharmacy/index.html" target="_blank">ادمین داروخانه</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    <li class="login-link">--}}
{{--        <a href="login.html">‌ورود / ثبت‌نام</a>--}}
{{--    </li>--}}
{{--</ul>--}}
