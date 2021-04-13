<div class="position-relative">
    @can('page update')
        <a class="btn btn-setting mb-5" x-on:click="setwidget('ThemeSettings')"  style="top:13px;left:5px" href="{{ url("/admin/theme/$theme->id/edit?iframe=true#hdr") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
    @endcan
    <img src="{{  url(theme_option('logo', '/assets/garrin/img/logo.png'))  }}" width="100px" class="img-fluid header_logo" alt="Logo">
</div>
