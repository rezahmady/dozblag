<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="@yield('meta_keywords', theme_option('meta_keywords'))" >
        <meta name="description" content="@yield('meta_description', theme_option('meta_description'))">
        <meta name="author" content="Reza Ahmadi Sabzevar">
        <meta http-equiv="origin-trial" content="AgkruLcBqv/ofyNe+qNo1wL+x0hjaxtzqmkcK110waLMg10Hyfl5yYFdnYLm687rkJMMW0HTkBXXrw5R2bHEfAsAAABqeyJvcmlnaW4iOiJodHRwczovL2dhcmlpbi5jb206NDQzIiwiZmVhdHVyZSI6IldlYkFwcExpbmtDYXB0dXJpbmciLCJleHBpcnkiOjE2MzQwODMxOTksImlzU3ViZG9tYWluIjp0cnVlfQ==">
        <link rel="web-app-origin-association" href="/web-app-origin-association">
        <meta http-equiv="ScreenOrientation" content="autoRotate:disabled">
		<title>@yield('meta_title') | {{ theme_option('meta_title') }}</title>

		<!-- Favicons -->
        <link rel="icon" type="image/png" href="{{ theme_option('favicon') }}">
        <link rel="manifest" href="{{url('/manifest.json')}}" />
        <script type="module">
            import '/pwaupdate.js';
            const el = document.createElement('pwa-update');
            document.body.appendChild(el);
        </script>
        <!-- Links of CSS files -->
        @livewireStyles
        <link rel="stylesheet" href="{{ asset('/packages/line-awesome/css/line-awesome.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('/assets/garrin/css/eac4d452.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/garrin/js/plugins/select2/css/select2.min.css') }}" />
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
        <script src="{{asset('assets/garrin/js/plugins/select2/js/select2.min.js')}}" defer></script>
        <script src="{{ asset('/packages/nicescroll/nicescroll.min.js') }}" defer></script>
        <script src="{{ asset('/assets/garrin/js/custom.js') }}" defer></script>
        @livewireScripts
        <script src="{{ asset('/assets/js/livewire-turbolinks.js') }}" data-turbolinks-eval="false" defer></script>
		<script src="{{ asset('/assets/js/alpine.min.js') }}" defer></script>
	</head>
	<body>
        {!! theme_option('custom_html') !!}
        <style>
            .chat-holder {
                border: none;
                position: fixed;
                left: 0;
                top: 0;
                width: 330px;
                height: 100vh;
                z-index: 100000;
            }

            .responsive-iframe {
                height: 100%;
                width: 100%;
                border: 0;
            }
        </style>
        {{-- <div class="chat-holder" x-show="chatShow" x-on:click="chatShow = false">
            <iframe class="responsive-iframe" src="{{ route('chatyno.index') }}?iframe=true"></iframe>
        </div> --}}

		<!-- Main Wrapper -->
		<div class="main-wrapper">

            {{ $slot }}

	    </div>
	   <!-- /Main Wrapper -->


        
        @stack('custom-script')
        @include('theme::partials.alerts')
	</body>
</html>
