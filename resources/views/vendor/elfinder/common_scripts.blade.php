        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" href="{{ asset($dir.'/css/jquery-ui.css') }}" />
        @if (!isset ($jquery) || (isset($jquery) && $jquery == true))
        <script src="{{ asset($dir.'/js/libs/jquery.min.js') }}"></script>
        @endif
        <script src="{{ asset($dir.'/js/libs/jquery-ui.min.js') }}"></script>

        <!-- elFinder JS (REQUIRED) -->
        <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>

        @if($locale)
            <!-- elFinder translation (OPTIONAL) -->
            <script src="{{ asset($dir."/js/i18n/elfinder.$locale.js") }}"></script>
        @endif