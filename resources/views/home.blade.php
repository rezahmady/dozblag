@extends('layouts.app')

@section('content')
    <!-- Start Main Banner -->
    <div class="hero-banner bg-white">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12">
                            <div class="hero-banner-content black-color">
                                <span class="sub-title">آموزش تحصیلی</span>
                            <h1>به بیرون فکر کنید و یک یادگیرنده را یاد بگیرید</h1>
                            <p>راک با معرفی همکاران خارج از کارآموزی و تجربه تحقیق در خارج از کشور ، از دانشجویان پشتیبانی می کند.</p>
    
                                <div class="btn-box">
                                    <a href="courses-2-columns-style-1.html" class="default-btn"><i class='bx bx-move-horizontal icon-arrow before'></i><span class="label">مشاهده دوره ها</span><i class="bx bx-move-horizontal icon-arrow after"></i></a>
    
                                    <a href="contact.html" class="optional-btn">الان شروع کن</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="hero-banner-image text-center">
                                <img src="assets/img/banner-img3.jpg" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Banner -->

    <!-- Start Funfacts Area -->
    <section class="funfacts-area pt-100">
        <div class="container">
            <div class="funfacts-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="single-funfact">
                            <div class="icon">
                                <i class='bx bxs-group'></i>
                            </div>
                            <h3 style="direction: ltr;" class="odometer" data-count="50">00</h3>
                            <p>مربیان خبره</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="single-funfact">
                            <div class="icon">
                                <i class='bx bx-book-reader'></i>
                            </div>
                            <h3 style="direction: ltr;" class="odometer" data-count="1754">00</h3>
                            <p>تمام دوره ها</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="single-funfact">
                            <div class="icon">
                                <i class='bx bx-user-pin'></i>
                            </div>
                            <h3 style="direction: ltr;" class="odometer" data-count="8190">00</h3>
                            <p>دانش آموزان راضی</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="single-funfact">
                            <div class="icon">
                                <i class='bx bxl-deviantart'></i>
                            </div>
                            <h3 style="direction: ltr;" class="odometer" data-count="654">00</h3>
                            <p>رویداد خلاقانه</p>
                        </div>
                    </div>
                </div>

                <div id="particles-js-circle-bubble"></div>
            </div>
        </div>
    </section>
    <!-- End Funfacts Area -->

    <!-- Start Courses Area -->
    <section class="courses-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-left">
                <span class="sub-title">دوره ها را کشف کنید</span>
                <h2>دوره های آنلاین محبوب ما</h2>
                <a href="courses-2-columns-style-2.html" class="default-btn">
                    <i class='bx bx-show-alt icon-arrow before'></i><span class="label">همه دوره ها</span><i class="bx bx-show-alt icon-arrow after"></i></a>
            </div>

            <div class="shorting-menu">
                <button class="filter" data-filter="all">همه (06)</button>
                <button class="filter" data-filter=".business">تجاری (02)</button>
                <button class="filter" data-filter=".design">طراحی (05)</button>
                <button class="filter" data-filter=".development">توسعه دهنده (04)</button>
                <button class="filter" data-filter=".language">زبان خارجه (02)</button>
                <button class="filter" data-filter=".management">مدیریت (03)</button>
                <button class="filter" data-filter=".photography">عکاسی (04)</button>
            </div>

            <div class="shorting">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mix business design language">
                        <div class="single-courses-item mb-30">
                            <div class="courses-image">
                                <a href="single-courses.html" class="d-block"><img src="assets/img/courses/1.jpg" alt="image"></a>
                            </div>

                            <div class="courses-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="course-author d-flex align-items-center">
                                        <img src="assets/img/user1.jpg" class="shadow" alt="image">
                                        <span>استیون اسمیت</span>
                                    </div>

                                    <div class="courses-rating">
                                        <div class="review-stars-rated">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star-half'></i>
                                        </div>
    
                                        <div class="rating-total">
                                            4.5 (2)
                                        </div>
                                    </div>
                                </div>

                                <h3><a href="single-courses.html" class="d-inline-block">دوره گواهینامه فناوری اطلاعات تخصصی راک</a></h3>
                                <p>آموزش شامل آموزش و یادگیری دانش است.</p>
                            </div>

                            <div class="courses-box-footer">
                                <ul>
                                    <li class="students-number">
                                        <i class='bx bx-user'></i> 10 دانشجو
                                    </li>

                                    <li class="courses-lesson">
                                        <i class='bx bx-book-open'></i> 6 درس
                                    </li>

                                    <li class="courses-price">
                                        رایگان
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix design development management photography">
                        <div class="single-courses-item mb-30">
                            <div class="courses-image">
                                <a href="single-courses.html" class="d-block"><img src="assets/img/courses/2.jpg" alt="image"></a>
                            </div>

                            <div class="courses-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="course-author d-flex align-items-center">
                                        <img src="assets/img/user2.jpg" class="shadow" alt="image">
                                        <span>استیون اسمیت</span>
                                    </div>

                                    <div class="courses-rating">
                                        <div class="review-stars-rated">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star-half'></i>
                                        </div>
    
                                        <div class="rating-total">
                                            4.5 (2)
                                        </div>
                                    </div>
                                </div>

                                <h3><a href="single-courses.html" class="d-inline-block">دوره گواهینامه فناوری اطلاعات تخصصی راک</a></h3>
                                <p>آموزش شامل آموزش و یادگیری دانش است.</p>
                            </div>

                            <div class="courses-box-footer">
                                <ul>
                                    <li class="students-number">
                                        <i class='bx bx-user'></i> 10 دانشجو
                                    </li>

                                    <li class="courses-lesson">
                                        <i class='bx bx-book-open'></i> 6 درس
                                    </li>

                                    <li class="courses-price">
                                        250 تومان
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix development business management">
                        <div class="single-courses-item mb-30">
                            <div class="courses-image">
                                <a href="single-courses.html" class="d-block"><img src="assets/img/courses/3.jpg" alt="image"></a>
                            </div>

                            <div class="courses-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="course-author d-flex align-items-center">
                                        <img src="assets/img/user3.jpg" class="shadow" alt="image">
                                        <span>استیون اسمیت</span>
                                    </div>

                                    <div class="courses-rating">
                                        <div class="review-stars-rated">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bx-star'></i>
                                        </div>
    
                                        <div class="rating-total">
                                            4.0 (1)
                                        </div>
                                    </div>
                                </div>

                                <h3><a href="single-courses.html" class="d-inline-block">دوره گواهینامه فناوری اطلاعات تخصصی راک</a></h3>
                                <p>آموزش شامل آموزش و یادگیری دانش است.</p>
                            </div>

                            <div class="courses-box-footer">
                                <ul>
                                    <li class="students-number">
                                        <i class='bx bx-user'></i> 10 دانشجو
                                    </li>

                                    <li class="courses-lesson">
                                        <i class='bx bx-book-open'></i> 6 درس
                                    </li>

                                    <li class="courses-price">
                                        150 تومان
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix language design development photography">
                        <div class="single-courses-item mb-30">
                            <div class="courses-image">
                                <a href="single-courses.html" class="d-block"><img src="assets/img/courses/4.jpg" alt="image"></a>
                            </div>

                            <div class="courses-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="course-author d-flex align-items-center">
                                        <img src="assets/img/user4.jpg" class="shadow" alt="image">
                                        <span>استیون اسمیت</span>
                                    </div>

                                    <div class="courses-rating">
                                        <div class="review-stars-rated">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bx-star'></i>
                                        </div>
    
                                        <div class="rating-total">
                                            4.0 (1)
                                        </div>
                                    </div>
                                </div>

                                <h3><a href="single-courses.html" class="d-inline-block">دوره گواهینامه فناوری اطلاعات تخصصی راک</a></h3>
                                <p>آموزش شامل آموزش و یادگیری دانش است.</p>
                            </div>

                            <div class="courses-box-footer">
                                <ul>
                                    <li class="students-number">
                                        <i class='bx bx-user'></i> 10 دانشجو
                                    </li>

                                    <li class="courses-lesson">
                                        <i class='bx bx-book-open'></i> 6 درس
                                    </li>

                                    <li class="courses-price">
                                        <span>200 تومان</span>
                                        195 تومان
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix management design photography">
                        <div class="single-courses-item mb-30">
                            <div class="courses-image">
                                <a href="single-courses.html" class="d-block"><img src="assets/img/courses/5.jpg" alt="image"></a>
                            </div>

                            <div class="courses-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="course-author d-flex align-items-center">
                                        <img src="assets/img/user5.jpg" class="shadow" alt="image">
                                        <span>استیون اسمیت</span>
                                    </div>

                                    <div class="courses-rating">
                                        <div class="review-stars-rated">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                        </div>
    
                                        <div class="rating-total">
                                            5.0 (1)
                                        </div>
                                    </div>
                                </div>

                                <h3><a href="single-courses.html" class="d-inline-block">دوره گواهینامه فناوری اطلاعات تخصصی راک</a></h3>
                                <p>آموزش شامل آموزش و یادگیری دانش است.</p>
                            </div>

                            <div class="courses-box-footer">
                                <ul>
                                    <li class="students-number">
                                        <i class='bx bx-user'></i> 10 دانشجو
                                    </li>

                                    <li class="courses-lesson">
                                        <i class='bx bx-book-open'></i> 6 درس
                                    </li>

                                    <li class="courses-price">
                                        75 تومان
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix photography design development photography">
                        <div class="single-courses-item mb-30">
                            <div class="courses-image">
                                <a href="single-courses.html" class="d-block"><img src="assets/img/courses/6.jpg" alt="image"></a>
                            </div>

                            <div class="courses-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="course-author d-flex align-items-center">
                                        <img src="assets/img/user6.jpg" class="shadow" alt="image">
                                        <span>استیون اسمیت</span>
                                    </div>

                                    <div class="courses-rating">
                                        <div class="review-stars-rated">
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bxs-star'></i>
                                            <i class='bx bx-star'></i>
                                        </div>
    
                                        <div class="rating-total">
                                            4.0 (1)
                                        </div>
                                    </div>
                                </div>

                                <h3><a href="single-courses.html" class="d-inline-block">دوره گواهینامه فناوری اطلاعات تخصصی راک</a></h3>
                                <p>آموزش شامل آموزش و یادگیری دانش است.</p>
                            </div>

                            <div class="courses-box-footer">
                                <ul>
                                    <li class="students-number">
                                        <i class='bx bx-user'></i> 10 دانشجو
                                    </li>

                                    <li class="courses-lesson">
                                        <i class='bx bx-book-open'></i> 6 درس
                                    </li>

                                    <li class="courses-price">
                                        500 تومان
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Courses Area -->

    <!-- Start Courses Categories Area -->
    <section class="courses-categories-area pb-70">
        <div class="container">
            <div class="section-title text-left">
                <span class="sub-title">دسته بندی دوره ها</span>
                <h2>دسته بندی های گرایش را مرور کنید</h2>
                <a href="courses-category-style-2.html" class="default-btn"><i class='bx bx-show-alt icon-arrow before'></i><span class="label">مشاهده همه</span><i class="bx bx-show-alt icon-arrow after"></i></a>
            </div>

            <div class="courses-categories-slides owl-carousel owl-theme">
                <div class="single-categories-courses-item bg1 mb-30">
                    <div class="icon">
                        <i class='bx bx-code-alt'></i>
                    </div>
                    <h3>توسعه دهنده وب</h3>
                    <span>60 دوره آموزش</span>

                    <a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>

                    <a href="#" class="link-btn"></a>
                </div>

                <div class="single-categories-courses-item bg2 mb-30">
                    <div class="icon">
                        <i class='bx bx-camera'></i>
                    </div>
                    <h3>فتوگرافی </h3>
                    <span>21 دوره آموزش</span>

                    <a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>

                    <a href="#" class="link-btn"></a>
                </div>

                <div class="single-categories-courses-item bg3 mb-30">
                    <div class="icon">
                        <i class='bx bx-layer'></i>
                    </div>
                    <h3>طراحی گرافیک</h3>
                    <span>58 دوره آموزش</span>

                    <a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>

                    <a href="#" class="link-btn"></a>
                </div>

                <div class="single-categories-courses-item bg4 mb-30">
                    <div class="icon">
                        <i class='bx bxs-flag-checkered'></i>
                    </div>
                    <h3>زبان برنامه نویسی</h3>
                    <span>99 دوره آموزش</span>

                    <a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>

                    <a href="#" class="link-btn"></a>
                </div>

                <div class="single-categories-courses-item bg5 mb-30">
                    <div class="icon">
                        <i class='bx bx-health'></i>
                    </div>
                    <h3>سلامتی و تندرستی</h3>
                    <span>21 دوره آموزش</span>

                    <a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>

                    <a href="#" class="link-btn"></a>
                </div>

                <div class="single-categories-courses-item bg6 mb-30">
                    <div class="icon">
                        <i class='bx bx-line-chart'></i>
                    </div>
                    <h3>مهارت تجاری</h3>
                    <span>49 دوره آموزش</span>

                    <a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>

                    <a href="#" class="link-btn"></a>
                </div>
            </div>
        </div>

        <div id="particles-js-circle-bubble-2"></div>
    </section>
    <!-- End Courses Categories Area -->

    <!-- Start Partner Area -->
    <section class="partner-area pb-100">
        <div class="container">
            <div class="section-title">
                <h2>
                شرکت و همکاران ما
                </h2>
            </div>

            <div class="partner-slides owl-carousel owl-theme">
                <div class="single-partner-item">
                    <a href="#" class="d-block">
                        <img src="assets/img/partner/7.png" alt="image">
                    </a>
                </div>

                <div class="single-partner-item">
                    <a href="#" class="d-block">
                        <img src="assets/img/partner/8.png" alt="image">
                    </a>
                </div>

                <div class="single-partner-item">
                    <a href="#" class="d-block">
                        <img src="assets/img/partner/9.png" alt="image">
                    </a>
                </div>

                <div class="single-partner-item">
                    <a href="#" class="d-block">
                        <img src="assets/img/partner/10.png" alt="image">
                    </a>
                </div>

                <div class="single-partner-item">
                    <a href="#" class="d-block">
                        <img src="assets/img/partner/11.png" alt="image">
                    </a>
                </div>

                <div class="single-partner-item">
                    <a href="#" class="d-block">
                        <img src="assets/img/partner/12.png" alt="image">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Partner Area -->

    <!-- Start Become Instructor & Partner Area -->
    <section class="become-instructor-partner-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="become-instructor-partner-content bg-color">
                        <h2>تبدیل به یک مربی شوید</h2>
                        <p>از میان صدها دوره رایگان انتخاب کنید یا مدرک را با قیمت دستیابی به موفقیت کسب کنید. با سرعت خود بیاموزید.</p>
                        <a href="login.html" class="default-btn"><i class='bx bx-plus-circle icon-arrow before'></i><span class="label">اکنون بپذیر</span><i class="bx bx-plus-circle icon-arrow after"></i></a>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="become-instructor-partner-image bg-image1 jarallax" data-jarallax='{"speed": 0.3}'>
                        <img src="assets/img/become-instructor.jpg" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="become-instructor-partner-image bg-image2 jarallax" data-jarallax='{"speed": 0.3}'>
                        <img src="assets/img/become-partner.jpg" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="become-instructor-partner-content">
                        <h2>شریک شدن</h2>
                        <p>از میان صدها دوره رایگان انتخاب کنید یا مدرک را با قیمت دستیابی به موفقیت کسب کنید. با سرعت خود بیاموزید.</p>
                        <a href="login.html" class="default-btn"><i class='bx bx-plus-circle icon-arrow before'></i><span class="label">تماس با ما</span><i class="bx bx-plus-circle icon-arrow after"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Become Instructor & Partner Area -->

    <!-- Start Testimonials Area -->
    <section class="testimonials-area pt-100">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">مشتریان</span>
                <h2>آنچه دانشجویان می گویند</h2>
            </div>

            <div class="testimonials-slides owl-carousel owl-theme">
                <div class="single-testimonials-item">
                    <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.</p>

                    <div class="info">
                        <img src="assets/img/user1.jpg" class="shadow rounded-circle" alt="image">
                        <h3>جان اسمیت</h3>
                        <span>دانشجو</span>
                    </div>
                </div>

                <div class="single-testimonials-item">
                    <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.</p>

                    <div class="info">
                        <img src="assets/img/user2.jpg" class="shadow rounded-circle" alt="image">
                        <h3>جان اسمیت</h3>
                        <span>دانشجو</span>
                    </div>
                </div>

                <div class="single-testimonials-item">
                    <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.</p>

                    <div class="info">
                        <img src="assets/img/user3.jpg" class="shadow rounded-circle" alt="image">
                        <h3>جان اسمیت</h3>
                        <span>دانشجو</span>
                    </div>
                </div>

                <div class="single-testimonials-item">
                    <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.</p>

                    <div class="info">
                        <img src="assets/img/user4.jpg" class="shadow rounded-circle" alt="image">
                        <h3>جان اسمیت</h3>
                        <span>دانشجو</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Testimonials Area -->

    <!-- Start Blog Area -->
    <section class="blog-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-left">
                <span class="sub-title">اخبار را کاوش کنید</span>
                <h2>آخرین اخبار ما</h2>
                <a href="blog-style-1.html" class="default-btn"><i class='bx bx-book-reader icon-arrow before'></i><span class="label">خواندن همه</span><i class="bx bx-book-reader icon-arrow after"></i></a>
            </div>

            <div class="blog-slides owl-carousel owl-theme">
                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="single-blog.html" class="d-block">
                            <img src="assets/img/blog/1.jpg" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">یادگیری</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="assets/img/user1.jpg" class="d-inline-block rounded-circle mr-2" alt="image">
                                توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>
                            </li>
                            <li><a href="#">30 دی 1398</a></li>
                        </ul>
                        <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>
                        <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>
                    </div>
                </div>

                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="single-blog.html" class="d-block">
                            <img src="assets/img/blog/2.jpg" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">آموزشی</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="assets/img/user2.jpg" class="d-inline-block rounded-circle mr-2" alt="image">
                                توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>
                            </li>
                            <li><a href="#">30 دی 1398</a></li>
                        </ul>
                        <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>
                        <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>
                    </div>
                </div>

                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="single-blog.html" class="d-block">
                            <img src="assets/img/blog/3.jpg" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">مدیریت</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="assets/img/user3.jpg" class="d-inline-block rounded-circle mr-2" alt="image">
                                توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>
                            </li>
                            <li><a href="#">30 دی 1398</a></li>
                        </ul>
                        <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>
                        <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>
                    </div>
                </div>

                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="single-blog.html" class="d-block">
                            <img src="assets/img/blog/4.jpg" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">ایده یابی</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="assets/img/user5.jpg" class="d-inline-block rounded-circle mr-2" alt="image">
                                توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>
                            </li>
                            <li><a href="#">30 دی 1398</a></li>
                        </ul>
                        <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>
                        <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>
                    </div>
                </div>

                <div class="single-blog-post mb-30">
                    <div class="post-image">
                        <a href="single-blog.html" class="d-block">
                            <img src="assets/img/blog/5.jpg" alt="image">
                        </a>

                        <div class="tag">
                            <a href="#">کار و مهارت</a>
                        </div>
                    </div>

                    <div class="post-content">
                        <ul class="post-meta">
                            <li class="post-author">
                                <img src="assets/img/user6.jpg" class="d-inline-block rounded-circle mr-2" alt="image">
                                توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>
                            </li>
                            <li><a href="#">30 دی 1398</a></li>
                        </ul>
                        <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>
                        <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Blog Area -->
@endsection