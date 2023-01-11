<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">

<head>
  @include(backpack_view('inc.head'))

</head>

<body class="{{ config('backpack.base.body_class') }}">
  <div id="overlayer"></div>
  <span class="loader">
    <span class="loader-inner"></span>
  </span>
  <div class="graphic-header">
      <svg width="883px" height="584px" viewBox="0 0 883 584" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
          <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="a">
            <stop stop-color="#F7FAFC" offset="0%"></stop>
            <stop stop-color="#DFEBF7" offset="100%"></stop>
          </linearGradient>
        </defs>
        <path d="M835.746-2.683c58.652 62.415 62.704 127.241 12.158 194.48C772.084 292.655 402.786 394.5 283.349 387.5 203.725 382.833 108.61 449-2 586V-14L835.746-2.683z" fill="url(#a)" fill-rule="evenodd"></path>
      </svg>
  </div>
  @include(backpack_view('inc.main_header'))

  <div class="app-body">

    @include(backpack_view('inc.sidebar'))

    <main class="main pt-2">

       @yield('before_breadcrumbs_widgets')

       @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))

       @yield('after_breadcrumbs_widgets')

       @yield('header')

        <div class="container-fluid animated fadeIn">

          @yield('before_content_widgets')

          @yield('content')
          
          @yield('after_content_widgets')

        </div>

    </main>

  </div><!-- ./app-body -->

  <footer class="{{ config('backpack.base.footer_class') }}">
    @include(backpack_view('inc.footer'))
  </footer>

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')
</body>
</html>