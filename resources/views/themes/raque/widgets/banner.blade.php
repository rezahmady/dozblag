<div class="hero-banner bg-white">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container-fluid">
              
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 position-relative">
                        @can('page update')
                            <a class="btn btn-setting mb-5" style="top:-42px;right:120px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true#bnr") }}" data-lity ><i class="bx bx-cog" wire:loading.class="loader"></i></a>
                        @endcan
                        <div class="hero-banner-content black-color">
                            <span class="sub-title">آموزش تحصیلی</span>
                        <h1>{{ $widget->banner_title }}</h1>
                        <p>{{ $widget->banner_description }}</p>

                            <div class="btn-box">
                                @if ($widget->banner_button_visible)
                                <a href="{{ $widget->banner_button_link}}" class="default-btn"><i class='bx bx-move-horizontal icon-arrow before'></i><span class="label">{{ $widget->banner_button_title }}</span><i class="bx bx-move-horizontal icon-arrow after"></i></a>
                                @endif
                                @if ($widget->banner_link_visible)
                                <a href="{{ $widget->banner_link_link }}" class="optional-btn">{{ $widget->banner_link_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="hero-banner-image text-center">
                            <img src="{{ asset($widget->image) }}" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>