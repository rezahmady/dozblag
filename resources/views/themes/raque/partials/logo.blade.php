<div class="position-relative">
    @can('page update')
        <a class="btn btn-setting mb-5" style="top:3px;left:-50px" href="{{ url("/admin/theme/$theme->id/edit?iframe=true#hdr") }}" data-lity ><i class="bx bx-cog" wire:loading.class="loader"></i></a>
    @endcan
    <img src="{{  url(theme_option('logo', '/assets/raque/img/black-logo.png'))  }}" alt="logo">
</div>