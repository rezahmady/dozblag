<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="{{ theme_option('meta_keywords') }}" >
        <meta name="description" content="{{ theme_option('meta_description') }}">
        <meta name="author" content="Reza Ahmadi Sabzevar">
		<title>{{ theme_option('meta_title') }}</title>
		
		<!-- Favicons -->
        <link rel="icon" type="image/png" href="{{ theme('img/favicon.png') }}">

        <!-- Links of CSS files -->
        @livewireStyles
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.css" integrity="sha512-NDcw4w5Uk5nra1mdgmYYbghnm2azNRbxeI63fd3Zw72aYzFYdBGgODILLl1tHZezbC8Kep/Ep/civILr5nd1Qw==" crossorigin="anonymous" />
        <link rel="stylesheet" href="{{ mix('/assets/garrin/css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/garrin/css/custom.css') }}">
		{{-- <link rel="stylesheet" href="{{ mix('/assets/css/app.css') }}"> --}}
        @stack('custom-style')
	
	</head>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			<header class="header">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</a>
						<a href="index.html" class="navbar-brand logo">
							<img src="assets/img/logo.png" class="img-fluid" alt="Logo">
						</a>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							<a href="index.html" class="menu-logo">
								<img src="assets/img/logo.png" class="img-fluid" alt="Logo">
							</a>
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</a>
						</div>
						<ul class="main-nav">
							<li class="active">
								<a href="index.html">خانه</a>
							</li>
							<li class="has-submenu">
								<a href="#">پزشک‌ها<i class="fas fa-chevron-down"></i></a>
								<ul class="submenu">
									<li><a href="doctor-dashboard.html">دشبرد پزشک</a></li>
									<li><a href="appointments.html">نوبت‌دهی</a></li>
									<li><a href="schedule-timings.html">زمان‌بندی</a></li>
									<li><a href="my-patients.html">لیست بیماران</a></li>
									<li><a href="patient-profile.html">پروفایل بیماران</a></li>
									<li><a href="chat-doctor.html">چت</a></li>
									<li><a href="invoices.html">صورت‌حساب</a></li>
									<li><a href="doctor-profile-settings.html">تنظیمات پروفایل</a></li>
									<li><a href="reviews.html">نظرات</a></li>
									<li><a href="doctor-register.html">ثبت‌نام پزشک</a></li>
									<li class="has-submenu">
										<a href="doctor-blog.html">بلاگ</a>
										<ul class="submenu">
											<li><a href="doctor-blog.html">بلاگ</a></li>
											<li><a href="blog-details.html">مشاهده بلاگ</a></li>
											<li><a href="doctor-add-blog.html">افزودن بلاگ</a></li>
										</ul>
									</li>
								</ul>
							</li>	
							<li class="has-submenu">
								<a href="#">مراجعه‌کنندگان<i class="fas fa-chevron-down"></i></a>
								<ul class="submenu">
									<li class="has-submenu">
										<a href="#">پزشکان</a>
										<ul class="submenu">
											<li><a href="map-grid.html">گرید نقشه</a></li>
											<li><a href="map-list.html">لیست نقشه</a></li>
										</ul>
									</li>
									<li><a href="search.html">جستجو پزشک</a></li>
									<li><a href="doctor-profile.html">پروفایل پزشک</a></li>
									<li><a href="booking.html">رزرو نوبت</a></li>
									<li><a href="checkout.html">پرداخت</a></li>
									<li><a href="booking-success.html">رزرو موفق</a></li>
									<li><a href="patient-dashboard.html">دشبرد مراجعه‌کننده</a></li>
									<li><a href="favourites.html">‌علاقه‌مندیها</a></li>
									<li><a href="chat.html">چت</a></li>
									<li><a href="profile-settings.html">تنظیمات پروفایل</a></li>
									<li><a href="change-password.html">‌تغییر رمز عبور</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="#">‌داروخانه<i class="fas fa-chevron-down"></i></a>
								<ul class="submenu">
									<li><a href="pharmacy-index.html">‌داروخانه</a></li>
									<li><a href="pharmacy-details.html">‌جزییات داروخانه</a></li>
									<li><a href="pharmacy-search.html">‌جستجو داروخانه</a></li>
									<li><a href="product-all.html">‌محصولات</a></li>
									<li><a href="product-description.html">توضیحات محصول</a></li>
									<li><a href="cart.html">‌سبد خرید</a></li>
									<li><a href="product-checkout.html">‌خرید محصولات</a></li>
									<li><a href="payment-success.html">‌پرداخت موفق</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="#">‌صفحات<i class="fas fa-chevron-down"></i></a>
								<ul class="submenu">
									<li><a href="voice-call.html">‌تماس صوتی</a></li>
									<li><a href="video-call.html">‌تماس تصویری</a></li>
									<li><a href="search.html">‌جستجو پزشک</a></li>
									<li><a href="calendar.html">‌تقویم</a></li>
									
									<li><a href="components.html">‌کامپوننت‌ها</a></li>
									<li class="has-submenu">
										<a href="invoices.html">صورت‌حساب</a>
										<ul class="submenu">
											<li><a href="invoices.html">صورت‌حساب</a></li>
											<li><a href="invoice-view.html">‌مشاهده صورت‌حساب</a></li>
										</ul>
									</li>
									<li><a href="blank-page.html">‌صفحه شروع</a></li>
									<li><a href="login.html">‌ورود</a></li>
									<li><a href="register.html">‌ثبت‌نام</a></li>
									<li><a href="forgot-password.html">‌فراموشی رمزعبور</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="#">‌بلاگ<i class="fas fa-chevron-down"></i></a>
								<ul class="submenu">
									<li><a href="blog-list.html">‌لیست بلاگ</a></li>
									<li><a href="blog-grid.html">‌گرید بلاگ</a></li>
									<li><a href="blog-details.html">‌جزییات بلاگ</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="#" target="_blank">ادمین<i class="fas fa-chevron-down"></i></a>
								<ul class="submenu">
									<li><a href="admin/index.html" target="_blank">‌ادمین</a></li>
									<li><a href="pharmacy/index.html" target="_blank">ادمین داروخانه</a></li>
								</ul>
							</li>
							<li class="login-link">
								<a href="login.html">‌ورود / ثبت‌نام</a>
							</li>
						</ul>		 
					</div>		 
					<ul class="nav header-navbar-rht">
						
						<li class="nav-item">
							<button type="button" class="button kt-modal-button button-light kt-login-button" data-modal="login">ورود</button>
						</li>

						<li class="nav-item">
							<button type="button" class="button kt-modal-button button-info kt-register-button" data-modal="login">ثبت‌نام</button>
						</li>
					</ul>
				</nav>
			</header>
			<!-- /Header -->

            {{ $slot }}
			
		
			
			<!-- Footer -->
			<footer class="footer">
				<div class="footer-top box-shadow border-button"></div>
				<!-- Footer Top -->
				<div class="footer-top bg-cover-08">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									<div class="footer-logo">
										<img src="assets/img/footer-logo.png" alt="logo">
									</div>
									<div class="footer-about-content">
										<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است</p>
										<div class="social-icon">
											<ul>
												<li>
													<a href="#" target="_blank"><i class="fab fa-facebook-f"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-twitter"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-dribbble"></i> </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">برای مراجعه‌کنندگان</h2>
									<ul>
										<li><a href="search.html">جستجو پزشکان</a></li>
										<li><a href="login.html">‌ورود</a></li>
										<li><a href="register.html">‌ثبت‌نام</a></li>
										<li><a href="booking.html">رزرو نوبت</a></li>
										<li><a href="patient-dashboard.html">دشبرد مراجعه‌کننده</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">برای پزشکان</h2>
									<ul>
										<li><a href="appointments.html">نوبت‌دهی</a></li>
										<li><a href="chat.html">چت</a></li>
										<li><a href="login.html">‌ورود</a></li>
										<li><a href="doctor-register.html">‌ثبت‌نام</a></li>
										<li><a href="doctor-dashboard.html">دشبرد پزشک</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-contact">
									<h2 class="footer-title">ارتباط با ما</h2>
									<div class="footer-contact-info">
										<div class="footer-address">
											<span><i class="fas fa-map-marker-alt"></i></span>
											<p> خیابان ارم، سانفرانسیسکو<br> کالیفرنیا خیابان 94108 </p>
										</div>
										<p>
											<i class="fas fa-phone-alt"></i>
											+1 315 369 5943
										</p>
										<p class="mb-0">
											<i class="fas fa-envelope"></i>
											doccure@example.com
										</p>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                <div class="footer-bottom">
					<div class="container-fluid">
					
						<!-- Copyright -->
						<div class="copyright bg-gradient-01">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0">&copy; 1399 داک‌کیور، تمامی حقوق محفوظ است.</p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
								
									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><a href="term-condition.html">شرایط و مقررات</a></li>
											<li><a href="privacy-policy.html">حریم شخصی</a></li>
										</ul>
									</div>
									<!-- /Copyright Menu -->
									
								</div>
							</div>
						</div>
						<!-- /Copyright -->
						
					</div>
				</div>
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
	    </div>
	   <!-- /Main Wrapper -->


        <!-- Links of JS files -->
        <script src="{{ mix('/assets/garrin/js/theme.js') }}" defer></script>
        <script src="{{ asset('/assets/garrin/js/custom.js') }}" defer></script>
		{{-- <script src="{{ mix('/assets/js/app.js') }}" defer></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js" defer integrity="sha512-UU0D/t+4/SgJpOeBYkY+lG16MaNF8aqmermRIz8dlmQhOlBnw6iQrnt4Ijty513WB3w+q4JO75IX03lDj6qQNA==" crossorigin="anonymous"></script>
        @livewireScripts
        @stack('custom-script')
		
	</body>
</html>