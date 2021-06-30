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
    <link rel="manifest" href="{{url('/manifest2.json')}}" defer />
        <script type="module">
            import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate';
            const el = document.createElement('pwa-update');
            document.body.appendChild(el);
        </script>
    <!-- Soho css -->
    <link rel="stylesheet" href="{{asset('packages/chatino/js/vendor/calamansijs/calamansi.min.css')}}">
    <link rel="stylesheet" href="/packages/chatino/css/soho.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('packages/chatino/css/green-audio-player.min.css')}}">
</head>
<body class="rtl">

<!-- page loading -->
<div class="page-loading"></div>
<!-- ./ page loading -->

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
@livewireScripts
@stack('scripts')

<script>
    if (window.location.search === '?iframe=true') {
        $('.lofout-button').css({ display: 'none' });
    }
</script>
</body>

</html>