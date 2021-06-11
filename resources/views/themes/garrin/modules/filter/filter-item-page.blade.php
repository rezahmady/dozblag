<div x-data="state()" x-init="init()">
    <!-- Header -->

    @php
    use Rezahmady\SettingOperation\Setting;
    @endphp
    <livewire:partials.header />
    <!-- /Header -->

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-color-0">
        <div>
            <div class="doctor-book-card-content tile-card-content-1"></div>
        </div>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="post-show-top-widget-box">
                    <div class="blog-single-categories-holder">
                        <div class="blog-single-categories">
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <i class="fa fa-home blog-item-popular"></i>
                            <a href="{{$filterItem->filter->path()}}" rel="category" data-wpel-link="internal">{{$filterItem->filter->name}}</a>
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a rel="category" data-wpel-link="internal">{{$filterItem->name}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-rounded-box" style="background: #f8f9fa" ></div>
    <!-- /Breadcrumb -->

    <section class="section home-section-comments" >
        <div class="container position-relative subscribe-page">
           @can('page edit')
           <a class="btn btn-setting mb-5"  x-on:click="setwidget('self-page')" style="right:0;" href="{{ url("admin/subscribtion/setting?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
           @endcan
            <!-- Section Header -->
            <div class="section-header filter-detail-holder position-relative ">
                <div class="filter-top-img-holder">
                    <img class="filter-img-top" style="width: 150px;" src="{{asset($filterItem->image)}}" alt="">
                </div>
                <h2 class="fw-800 text-center">{{$filterItem->name}}</h2>
                <div class="filter-top-description">
                    {!! $filterItem->description !!}
                </div>

            </div>
            <!-- /Section Header -->
    
            <div class="row blog-grid-row">
                <div class="col-md-6">
                    <div class="card text-center doctor-book-card">
                        <img src="{{asset($filterItem->services_image)}}" alt="" class="img-fluid">
                        <div class="doctor-book-card-content tile-card-content-1" style="background-image: linear-gradient(#26cabd82,#23b8b1c9);">
                            <div>
                                <h3 class="card-title mb-3">{{$filterItem->services_title}}</h3>
                                <div>
                                    {!! $filterItem->services_description !!}
                                </div>
                                <a href="{{route('filter.item.services', [$filter->slug,$filterItem->slug])}}" style="color: white;">
                                    ورود به {{$filterItem->services_title}}
                                    <i class="la la-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-center doctor-book-card">
                        <img src="{{asset($filterItem->articles_image)}}" alt="" class="img-fluid">
                        <div class="doctor-book-card-content tile-card-content-1" style="background-image:linear-gradient(#fd931e87,#e83972d6)">
                            <div>
                                <h3 class="card-title mb-3">{{$filterItem->articles_title}}</h3>
                                <div>
                                    {!! $filterItem->articles_description !!}
                                </div>
                                <a href="{{route('filter.item.articles', [$filter->slug,$filterItem->slug])}}" style="color: white;">
                                    ورود به {{$filterItem->articles_title}}
                                    <i class="la la-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    
        
    
    
    </section>

    <!-- Footer -->
    <livewire:partials.footer />
    <!-- /Footer -->
    <script>
        function state() {
            return {
                widget: @entangle('widget'),
                setwidget(widget) {
                    this.widget = widget;
                },
                init() {
                    $(document).on('lity:close', function(event, instance) {
                        setTimeout(() => {
                            Livewire.emit('update-widget');
                        }, 1500)
                    });
                },
            }
        }
    </script>
</div>