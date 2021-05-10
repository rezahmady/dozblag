<section class="section home-section-comments " >
    <div class="container position-relative subscribe-page">
        @php
            use Rezahmady\SettingOperation\Setting;
        @endphp
        {{-- @can('subscribtion manage') --}}
            <a class="btn btn-setting mb-5" style="right:0;" href="{{ url("admin/subscribtion/setting?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
        {{-- @endcan --}}
        <!-- Section Header -->
        <div class="section-header position-relative text-center">
            <h2 class="fw-800">{{Setting::get('subscribtions.title')}}</h2>
            {!! Setting::get('subscribtions.description') !!}
        </div>
        <!-- /Section Header -->

        <div class="row blog-grid-row">
            @foreach ($packages as $item)
            <div class="{{Setting::get('subscribtions.col_class')}}">
                <div class="card flex-fill bg-cover-09 position-relative">
                    <a class="btn btn-setting mb-5" style="right:0;" href="{{ url("admin/subscribtion/{$item->id}/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
                    <div class="card-body pb-5">
                        <h5 class="card-title fw-800">{{$item->name}}</h5>
                        {!! $item->description !!}
                        <a class="apt-btn" href="http://gariin.test/doctor/6" tabindex="0">{{Setting::get('subscribtions.button_label')}}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </div>

    
<script>

document.addEventListener("turbolinks:load", function() {
    $(document).on('lity:close', function(event, instance) {
        setTimeout(() => {
            Livewire.emit('update-page');
        }, 1500);
    });
});
    
</script>

</section>