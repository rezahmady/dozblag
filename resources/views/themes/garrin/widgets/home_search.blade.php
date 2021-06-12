<section class="section section-search">
    <div class="container-fluid d-flex">
        <div class="col-md-8 col-lg-8 col-12">
            <div class="banner-wrapper">
                <div class="text-center banner-header position-relative">
                    @can('page update')
                        <a class="mb-5 btn btn-setting" x-on:click="setwidget('{{$widget->name}}')" style="top:10px;right:20px" href="{{ url("/admin/widget/$widget->id/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
                    @endcan
                    <h1>{{$widget->search_title}}</h1>
                    <p>{{$widget->search_description}}</p>
                </div>

                <!-- Search -->
                <div class="search-box">
                    <form wire:submit.prevent="submit">
                        <div class="form-group search-info position-relative">
                            <input type="text" wire:model.debounce.2000="searchTerm" class="form-control" placeholder="{{$widget->input_placeholder}}">
                            <span class="form-text">{{$widget->input_hint}}</span>
                            @if ($result)
                            <div class="search-resault-holder">
                                @foreach ($users as $item)
                                @php
                                    $image = ($item->getProfile()) ? $item->getProfile() : asset('assets/admin/images/shop/product_noimage.png');
                                @endphp
                                <div class="resault">
                                    <div class="avatar">
                                        <img class="rounded avatar-img" alt="{{$item->name}}" src="{{$image}}">
                                    </div>
                                    <div>
                                        <h5 class="px-2 pt-0"><a href="{{$item->path()}}">{{$item->name}}</a></h5>
                                        <div class="pl-2 color-second small">
                                            <i class="las la-folder-open"></i>
                                            <span>پزشکان</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @foreach ($filters as $item)
                                @php
                                    $image = ($item->image) ? asset($item->image) : asset('assets/admin/images/shop/product_noimage.png');
                                @endphp
                                <div class="resault">
                                    <div class="avatar">
                                        <img class="rounded avatar-img" alt="{{$item->name}}" src="{{$image}}">
                                    </div>
                                    <div>
                                        <h5 class="px-2 pt-0"><a href="{{$item->path()}}">{{$item->name}}</a></h5>
                                        <div class="pl-2 color-second small">
                                            <i class="las la-folder-open"></i>
                                            <span>بخش ها</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @foreach ($resources as $item)
                                @php
                                    $image = ($item->getProfile()) ? $item->getProfile() : asset('assets/admin/images/shop/product_noimage.png');
                                @endphp
                                <div class="resault">
                                    <div class="avatar">
                                        <img class="rounded avatar-img" alt="{{$item->name}}" src="{{$image}}">
                                    </div>
                                    <div>
                                        <h5 class="px-2 pt-0"><a href="{{$item->path()}}">{{$item->name}}</a></h5>
                                        <div class="pl-2 color-second small">
                                            <i class="las la-folder-open"></i>
                                            <span>بانک سلامت</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @foreach ($mags as $item)
                                <div class="resault">
                                    @php
                                        $image = ($item->image) ? asset($item->image) : asset('assets/admin/images/shop/product_noimage.png');
                                    @endphp
                                    <div class="avatar">
                                        <img class="rounded avatar-img" alt="{{$item->title}}" src="{{$image}}">
                                    </div>
                                    <div>
                                        <h5 class="px-2 pt-0"><a href="{{$item->path()}}">{{$item->title}}</a></h5>
                                        <div class="pl-2 color-second small">
                                            <i class="las la-folder-open"></i>
                                            <span>مجله سلامت</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div  wire:loading class="loader-holder">
                                    <div  class="loader-spiner-01"></div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-accept search-btn">
                            <i  wire:loading.remove class="fas fa-search"></i> 
                            <div wire:loading>
                                <i wire:loading class="las la-spinner spinner"></i>
                            </div>
                            <span>جستجو</span>
                        </button>
                    </form>
                </div>
                <!-- /Search -->

            </div>
        </div>

        <div class="col-md-4 col-lg-4 col-12 d-none d-lg-block d-md-block">
            <img src="{{url($widget->header_img)}}" width="100%" alt="">
        </div>
    </div>

    <script>
        document.addEventListener("turbolinks:load", function() {
            $(document).ready(function () {
                $('.search-resault-holder').niceScroll({
                    autohidemode:'leave',
                    cursorborder:'none',
                    cursorcolor: '#cecece',
                });
            })
        })

        window.addEventListener('contentChanged:{{$widget->name}}', event => {
            $(document).ready(function () {
                $('.search-resault-holder').niceScroll({
                    autohidemode:'leave',
                    cursorborder:'none',
                    cursorcolor: '#cecece',
                });
            })
        });
    </script>
</section>