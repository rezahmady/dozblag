<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>پلت فرم مشاوره پزشکی</title>
    <meta http-equiv="origin-trial" content="AgkruLcBqv/ofyNe+qNo1wL+x0hjaxtzqmkcK110waLMg10Hyfl5yYFdnYLm687rkJMMW0HTkBXXrw5R2bHEfAsAAABqeyJvcmlnaW4iOiJodHRwczovL2dhcmlpbi5jb206NDQzIiwiZmVhdHVyZSI6IldlYkFwcExpbmtDYXB0dXJpbmciLCJleHBpcnkiOjE2MzQwODMxOTksImlzU3ViZG9tYWluIjp0cnVlfQ==">
    <link rel="web-app-origin-association" href="/web-app-origin-association.json">
    <meta http-equiv="ScreenOrientation" content="autoRotate:disabled">
    <link rel="stylesheet" href="{{asset('packages/chatino/css/lity.css')}}" >
    {{-- <script src="https://unpkg.com/wavesurfer.js"></script> --}}
    <script src="{{asset('packages/chatino/js/vendor/green-audio-player.min.js')}}" defer></script>
    <script src="{{asset('packages/chatino/js/vendor/recorder/recorder.js')}}" ></script>
    <script src="/packages/chatino/js/vendor/jquery.min.js" ></script>
    {{-- <script src="https://www.gstatic.com/firebasejs/4.4.0/firebase.js" defer></script>
    <script src="https://www.gstatic.com/firebasejs/4.4.0/firebase-app.js" defer></script>
    <script src="https://www.gstatic.com/firebasejs/4.4.0/firebase-messaging.js" defer></script> --}}

      <!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-messaging.js"></script>
    <script defer>
        // Initialize Firebase
        var firebaseConfig = {
            apiKey: "AIzaSyBEEI9LBfnspWNjUOu0L4zJCzVC-PUByUU",
            authDomain: "react-lesson-c7038.firebaseapp.com",
            databaseURL: "https://react-lesson-c7038.firebaseio.com",
            projectId: "react-lesson-c7038",
            storageBucket: "react-lesson-c7038.appspot.com",
            messagingSenderId: "652673181841",
            appId: "1:652673181841:web:44ecc7e7c42cba1e7ef730"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        // Get registration token. Initially this makes a network call, once retrieved
        // subsequent calls to getToken will return from cache.
        messaging.getToken({ vapidKey: 'BMg0EGK11H7ySQLwJJnj07H8-F7-Zm4HKcAukizdHrFAl0BIxnI3MfUDsPRyPTQBxoeJOqjKsDKekTKs7xrmBkU' }).then((currentToken) => {
        if (currentToken) {
            // Send the token to your server and update the UI if necessary
            // console.log(currentToken)
            // ...
        } else {
            // Show permission request UI
            console.log('No registration token available. Request permission to generate one.');
            // ...
        }
        }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        // ...
        });
        messaging.onMessage((payload) => {
            console.log('Message received. ', payload);
        // ...
        });
      </script>
    <!-- Favicon -->
    {{-- <link rel="icon" href="dist/media/img/favicon.png" type="image/png"> --}}
    <script src="{{ asset('/packages/nicescroll/nicescroll.min.js') }}" defer></script>
    @livewireStyles
    <script src="{{ mix('/assets/js/chat.js') }}"></script>
    <link rel="manifest" href="{{url('/manifest2.json')}}" defer />
        <script type="module">
            import '{{url("/pwaupdate.js")}}';
            const el = document.createElement('pwa-update');
            document.body.appendChild(el);
        </script>
    <!-- Soho css -->
    <link rel="stylesheet" href="{{asset('packages/chatino/js/vendor/calamansijs/calamansi.min.css')}}">
    <link rel="stylesheet" href="{{mix('/packages/chatino/css/chat.css')}}">
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
