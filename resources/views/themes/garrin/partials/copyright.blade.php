<div class="copyright-text position-relative">
    @can('page update')
        <a class="btn btn-setting mb-5" style="top:-30px;right:15px" href="{{ url("/admin/theme/$theme->id/edit?iframe=true#fotr") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
    @endcan
    {!! theme_option('copyright') !!}
</div>