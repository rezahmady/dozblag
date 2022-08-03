<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="@yield('meta_keywords', theme_option('meta_keywords'))" >
<meta name="description" content="@yield('meta_description', theme_option('meta_description'))">
<title>@yield('meta_title') | {{ theme_option('meta_title') }}</title>
<link rel="icon" type="image/png" href="{{ theme_option('favicon') }}">
@livewireStyles
<script src="{{ asset('/assets/admin/packages/formeo/formeo.min.js') }}"></script>
<link rel="stylesheet" href="{{mix('/assets/css/app.css')}}" />