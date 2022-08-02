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
  border-radius: 10px;
  max-height: 90vh;
  background-color: #f1f4f8;
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
  animation: rotation .4s infinite linear;
}

.btn-setting {
  background: #039be5;
  border-radius: 5px !important;
  padding: 7px!important;
  color: white !important;
  position: absolute;
  margin: auto;
  width: max-content;
  display: flex;
  align-items: center;
  font-size: 12px;
  z-index: 2;
}

.btn-setting span {
  padding-right: 7px;
}

.btn-setting.icon-only span {
  padding-right: 0px;
}


.core-admin-bottom-navigation {
  width: 100%;
  position: fixed;
  bottom: 0;
  right: 0;
  left: 0;
  z-index: 100;
  background: #283252;
  display: flex;
  justify-content: space-between;
}

.core-admin-bottom-navigation a.button {
  border: 0;
  padding: 15px;
  background-color: inherit;
  color: white;
  border-left: 1px solid #6e7f94;
  cursor: pointer;
  border-radius: 0;
}


.core-admin-bottom-navigation a.button .options {
  position: absolute;
  width: auto;
  max-width: max-content;
  background-color: #283252;
  border-radius: 5px;
  bottom: 55px;
  box-shadow: 1px 2px 4px rgb(0 0 0 / 8%);
}

.core-admin-bottom-navigation a.button .options li {
  padding:10px 15px 10px 20px;
  cursor: pointer;
  border-bottom: 1px solid #232323;
  text-align: right;
  color: white;
}

.core-admin-bottom-navigation a.button i {
  padding-left: 5px; 
  padding-right: 5px; 
}

.core-admin-bottom-navigation a.button.back-to-admin {
  background-color: #039be5;
}

.loader-holder {
    position: absolute;
    background: #00000070;
    width: 100%;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    display: none;
    align-items: center;
    justify-content: center;
}

.d-flex {
  display: flex !important;
}

.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 20px;
  height: 20px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>