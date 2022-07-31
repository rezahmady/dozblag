<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="@yield('meta_keywords', theme_option('meta_keywords'))" >
<meta name="description" content="@yield('meta_description', theme_option('meta_description'))">
<title>@yield('meta_title') | {{ theme_option('meta_title') }}</title>
<link rel="icon" type="image/png" href="{{ theme_option('favicon') }}">
@livewireStyles
<script src="{{ asset('/assets/admin/packages/formeo/formeo.min.js') }}"></script>
<style>
.modal-overlay {
  position: fixed;
  box-sizing: border-box;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 40px;
  background: rgb(0 0 0 / 34%);
  display: flex;
  z-index: 1000;
}

.modal-overlay.is-open {
  display: block;
}

.modal-iframe-holder {
  width: 100%;
  height: auto;
  max-width: 600px;
  margin: auto;
  /* background-color: #f1f4f8; */
  border-radius: 10px;
}

.modal-iframe {
  width: 100%;
  transition: height 0.5s ease-in;
  border-radius: 20px;
}

.modal-button-close {
  position: absolute;
  top: 0;
  right: 10px;
  font-size: 40px;
  padding: 0;
  border: 0;
  color: white;
  font-weight: 900;
  background: none;
}

@keyframes rotation {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(359deg);
  }
}

.btn-setting i.loading {
  animation: rotation 1s infinite linear;
}

.btn-setting {
  background: #ffc107;
  border-radius: 0!important;
  padding: 4px 4px 0 4px!important;
  color: black;
}
</style>