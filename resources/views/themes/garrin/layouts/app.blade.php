<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="@yield('meta_keywords', theme_option('meta_keywords'))" >
        <meta name="description" content="@yield('meta_description', theme_option('meta_description'))">
        <meta name="author" content="Reza Ahmadi Sabzevar">
		<title>@yield('meta_title') | {{ theme_option('meta_title') }}</title>

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
			<livewire:partials.header :key="'partils_header" />
			<!-- /Header -->

            {{ $slot }}

			<!-- Footer -->
			<livewire:partials.footer :key="'partials_footer'" />
			<!-- /Footer -->

	    </div>
	   <!-- /Main Wrapper -->


        <!-- Links of JS files -->
        <script src="{{ mix('/assets/garrin/js/theme.js') }}" defer></script>
        <script src="{{ asset('/assets/garrin/js/custom.js') }}" defer></script>
		<script src="{{ mix('/assets/js/app.js') }}"></script>
		<script src="{{asset('packages/alpinejs/alpine.min.js')}}" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js" defer integrity="sha512-UU0D/t+4/SgJpOeBYkY+lG16MaNF8aqmermRIz8dlmQhOlBnw6iQrnt4Ijty513WB3w+q4JO75IX03lDj6qQNA==" crossorigin="anonymous"></script>
        @livewireScripts
        @stack('custom-script')

	</body>
</html>
