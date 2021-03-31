<section class="become-instructor-partner-area">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="become-instructor-partner-content bg-color position-relative">
                    @can('page update')
                            <a data-lity class="btn btn-setting mb-5" style="top:15px;right:15px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#kashy") }}" ><i class="bx bx-cog" wire:loading.class="loader"></i></a>
                    @endcan
                    <h2>{{ $widget->kashi_title }}</h2>
                    {!! $widget->kashi_description !!}
                    <a href="{{ $widget->kashi_button_link }}" class="default-btn"><i class='bx bx-plus-circle icon-arrow before'></i><span class="label">{{ $widget->kashi_button_label }}</span><i class="bx bx-plus-circle icon-arrow after"></i></a>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="become-instructor-partner-image " style="background-image: url('{{ $widget->image_bg }}')" >
                </div>
            </div>

        
        </div>
    </div>
</section>