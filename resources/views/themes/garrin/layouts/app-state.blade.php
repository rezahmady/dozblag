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
        <link rel="icon" type="image/png" href="{{ theme_option('favicon') }}">

        <!-- Links of CSS files -->
        @livewireStyles
        <link rel="stylesheet" href="{{ asset('/packages/line-awesome/css/line-awesome.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('/assets/garrin/css/eac4d452.css') }}" />
        <link rel="stylesheet" href="{{ asset('/packages/lity/lity.css') }}" />
        <link rel="stylesheet" href="{{ mix('/assets/garrin/css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/garrin/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('/packages/noty/noty.css') }}">
        <link rel="stylesheet" href="{{ asset('/packages/noty/themes/light.css') }}">
        @stack('custom-style')
        <!-- Links of JS files -->
        <script src="{{ mix('/assets/garrin/js/theme.js') }}" defer></script>
		<script src="{{ mix('/assets/js/app.js') }}"></script>
        <script src="{{ asset('/packages/lity/lity.min.js') }}" defer ></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js' defer ></script>
        <script src="{{ asset('/assets/garrin/js/custom.js') }}" defer></script>
        @livewireScripts
        <script src="{{ asset('/assets/js/livewire-turbolinks.js') }}" data-turbolinks-eval="false" defer></script>
		<script src="{{ asset('/assets/js/alpine.min.js') }}" defer></script>
	</head>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">

            {{ $slot }}

	    </div>
	   <!-- /Main Wrapper -->


        
        @stack('custom-script')
        @include('theme::partials.alerts')
	</body>
</html>
