<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>پلت فرم گفت و گو و بحث</title>
    <link rel="stylesheet" href="{{asset('packages/chatino/css/lity.css')}}" >
    {{-- <script src="https://unpkg.com/wavesurfer.js"></script> --}}
    <script src="{{asset('packages/chatino/js/vendor/green-audio-player.min.js')}}" defer></script>
    <script src="{{asset('packages/chatino/js/vendor/recorder/recorder.js')}}" ></script>
    <script src="/packages/chatino/js/vendor/jquery.min.js" ></script>
    <!-- Favicon -->
    {{-- <link rel="icon" href="dist/media/img/favicon.png" type="image/png"> --}}
    <script src="{{ asset('/packages/nicescroll/nicescroll.min.js') }}" defer></script>
    @livewireStyles
    <script src="{{ mix('/assets/js/chat.js') }}"></script>
    
    
    <!-- Soho css -->
    <link rel="stylesheet" href="{{asset('packages/chatino/js/vendor/calamansijs/calamansi.min.css')}}">
    <link rel="stylesheet" href="/packages/chatino/css/soho.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('packages/chatino/css/green-audio-player.min.css')}}">
</head>
<body class="rtl">

<!-- page loading -->
<div class="page-loading"></div>
<!-- ./ page loading -->

<!-- call modal -->
<div class="modal call fade" id="call" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="call">
                    <div class="call-background" style="background: url(dist/media/img/call-bg.png)"></div>
                    <div>
                        <figure class="mb-4 avatar avatar-xl">
                            <img src="/packages/chatino/media/img/women_avatar1.jpg" class="rounded-circle">
                        </figure>
                        <h4 class="text-center">جعفر عباسی در حال تماس ...</h4>
                        <div class="action-button">
                            <button type="button" class="btn btn-danger btn-floating btn-lg" data-dismiss="modal">
                                <i class="ti-close"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-pulse btn-floating btn-lg">
                                <i class="fa fa-phone"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./ call modal -->

<!-- add friends modal -->
<div class="modal fade" id="addFriends" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti-user"></i> افزودن دوستان
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">ارسال دعوت نامه به دوستان.</div>
                <form>
                    <div class="form-group">
                        <label for="emails" class="col-form-label">آدرس ایمیل</label>
                        <input type="text" class="form-control" id="emails">
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-form-label">پیام دعوت</label>
                        <textarea class="form-control" id="message"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">ارسال</button>
            </div>
        </div>
    </div>
</div>
<!-- ./ add friends modal -->

<!-- new group modal -->
<div class="modal fade" id="newGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-users"></i> گروه جدید
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="group_name" class="col-form-label">نام گروه</label>
                        <input type="text" class="form-control" id="group_name">
                    </div>
                    <div class="form-group">
                        <label for="users" class="col-form-label">کاربران</label>
                        <input type="text" class="form-control" id="users" placeholder="نام">
                    </div>
                    <div class="form-group">
                        <div class="avatar-group">
                            <figure class="avatar">
                                <span class="avatar-title bg-success rounded-circle">E</span>
                            </figure>
                            <figure class="avatar">
                                <img src="/packages/chatino/media/img/women_avatar1.jpg" class="rounded-circle">
                            </figure>
                            <figure class="avatar">
                                <span class="avatar-title bg-danger rounded-circle">S</span>
                            </figure>
                            <figure class="avatar">
                                <img src="/packages/chatino/media/img/man_avatar2.jpg" class="rounded-circle">
                            </figure>
                            <figure class="avatar">
                                <span class="avatar-title bg-info rounded-circle">C</span>
                            </figure>
                            <a href="#">
                                <figure class="avatar">
                                    <span class="avatar-title bg-primary rounded-circle">+</span>
                                </figure>
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">توضیحات</label>
                        <textarea class="form-control" id="description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">ایجاد گروه</button>
            </div>
        </div>
    </div>
</div>
<!-- ./ new group modal -->

<!-- setting modal -->
<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti-settings"></i> تنظیمات
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true">اکانت</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  data-toggle="tab" href="#notification" role="tab" aria-controls="notification" aria-selected="false">اعلانات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">امنیت</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="account" role="tabpanel">
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" checked id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1">مخاطبین متصل را مجاز کنید</label>
                        </div>
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" checked id="customSwitch2">
                            <label class="custom-control-label" for="customSwitch2">درخواست پیام را تأیید کنید</label>
                        </div>
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" checked id="customSwitch3">
                            <label class="custom-control-label" for="customSwitch3">حریم خصوصی پروفایل</label>
                        </div>
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch4">
                            <label class="custom-control-label" for="customSwitch4">گزینه های حالت برنامه نویس</label>
                        </div>
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" checked id="customSwitch5">
                            <label class="custom-control-label" for="customSwitch5">تأیید امنیتی دو مرحله ای</label>
                        </div>
                    </div>
                    <div class="tab-pane" id="notification" role="tabpanel">
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" checked id="customSwitch6">
                            <label class="custom-control-label" for="customSwitch6">اجازه اعلان های تلفن همراه</label>
                        </div>
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch7">
                            <label class="custom-control-label" for="customSwitch7">اعلان های دوستانتان</label>
                        </div>
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch8">
                            <label class="custom-control-label" for="customSwitch8">اعلان ها را از طریق ایمیل ارسال کنید</label>
                        </div>
                    </div>
                    <div class="tab-pane" id="contact" role="tabpanel">
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch9">
                            <label class="custom-control-label" for="customSwitch9">هر بار گذرواژه‌ها را تغییر دهید.</label>
                        </div>
                        <div class="form-item custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" checked id="customSwitch10">
                            <label class="custom-control-label" for="customSwitch10">بگذارید درباره ورود مشکوک به حساب شما اطلاع دهم</label>
                        </div>
                        <div class="form-item">
                            <p>
                                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <span class="ti-plus btn-icon"></span> سوالات امنیتی
                                </a>
                            </p>
                            <div class="collapse" id="collapseExample">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="سوال 1">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="سوال 2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">ذخیره</button>
            </div>
        </div>
    </div>
</div>
<!-- ./ setting modal -->

<!-- edit profile modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti-pencil"></i> ویرایش پروفایل
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="true">شخصی</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false">درباره</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  data-toggle="tab" href="#social-links" role="tab" aria-controls="social-links" aria-selected="false">لینک های اجتماعی</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="personal" role="tabpanel">
                        <form>
                            <div class="form-group">
                                <label for="fullname" class="col-form-label">نام کامل</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ti-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="fullname">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">آواتار</label>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <figure class="avatar mr-3 item-rtl">
                                            <img src="/packages/chatino/media/img/man_avatar3.jpg" class="rounded-circle">
                                        </figure>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">انتخاب فایل</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city" class="col-form-label">شهر</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="city">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-form-label">تلفن</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ti-mobile"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="phone" placeholder="(555) 555 55 55">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="website" class="col-form-label">وب سایت</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ti-link"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="website">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="about" role="tabpanel">
                        <form action="#">
                            <div class="form-group">
                                <label for="about-text" class="col-form-label">چند کلمه بنویسید که شما را توصیف می کند</label>
                                <textarea class="form-control" id="about-text"></textarea>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" checked id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">مشاهده نمایه</label>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="social-links" role="tabpanel">
                        <form action="#">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bg-facebook">
                                        <i class="ti-facebook"></i>
                                    </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="نام کاربری">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bg-twitter">
                                        <i class="ti-twitter"></i>
                                    </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="نام کاربری">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bg-instagram">
                                        <i class="ti-instagram"></i>
                                    </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="نام کاربری">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bg-linkedin">
                                        <i class="ti-linkedin"></i>
                                    </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="نام کاربری">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bg-dribbble">
                                        <i class="ti-dribbble"></i>
                                    </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="نام کاربری">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bg-youtube">
                                        <i class="ti-youtube"></i>
                                    </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="نام کاربری">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bg-google">
                                        <i class="ti-google"></i>
                                    </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="نام کاربری">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bg-whatsapp">
                                        <i class="fa fa-whatsapp"></i>
                                    </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="نام کاربری">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">ذخیره</button>
            </div>
        </div>
    </div>
</div>
<!-- ./ edit profile modal -->

<!-- layout -->
{{ $slot }}
<!-- ./ layout -->

<!-- JQuery -->


<!-- Popper.js -->
<script src="/packages/chatino/js/vendor/popper.min.js" defer></script>

<!-- Bootstrap -->
<script src="/packages/chatino/js/vendor/bootstrap/bootstrap.min.js" defer></script>

<!-- Nicescroll -->
<script src="/packages/chatino/js/vendor/jquery.nicescroll.min.js" defer></script>

<!-- Soho -->
<script src="/packages/chatino/js/soho.min.js" defer></script>
<script src="/packages/chatino/js/vendor/lity.min.js" defer></script>

<script src="{{asset('packages/chatino/js/vendor/calamansijs/calamansi.min.js')}}" defer></script>
<!-- Examples -->
{{-- <script src="{{ asset('/packages/chatino/js/vendor/RTLText.module.js') }}" defer></script> --}}
<script src="{{asset('packages/alpinejs/alpine.min.js')}}" defer></script>
<script src="{{asset('packages/chatino/js/vendor/recorder/app.js')}}" defer></script>
@livewireScripts
@stack('scripts')
</body>

</html>