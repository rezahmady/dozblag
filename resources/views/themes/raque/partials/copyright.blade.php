<div class="container">
    <div class="logo  position-relative width-max-content m-auto">
        @can('page update')
            <a class="btn btn-setting mb-5" style="top:3px;left:-50px" href="{{ url("/admin/theme/$theme->id/edit?iframe=true#fotr") }}" data-lity ><i class="bx bx-cog" wire:loading.class="loader"></i></a>
        @endcan
        <a href="{{ url('/')}}" class="d-inline-block"><img src="{{ url(theme_option('logo-footer', '/assets/raque/img/logo.png')) }}" alt="image"></a>
    </div>
    {!! theme_option('copyright') !!}
</div>