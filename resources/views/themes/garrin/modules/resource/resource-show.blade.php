@section('meta_title')
{{ $resource->meta_title ?? $resource->name}}
@endsection

@section('meta_description')
{!! $resource->meta_description ?? '' !!}
@endsection

@section('meta_keywords')
{{ $resource->meta_keywords}}
@endsection
<div>
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-svg-02">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="post-show-top-widget-box">
                    <div class="blog-single-categories-holder">
                        <div class="blog-single-categories">
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a href="{{ url('/') }}" ><i class="fa fa-home blog-item-popular"></i></a>
                            <a href="{{route('resource.all')}}" rel="category" data-wpel-link="internal">بانک سلامت</a>
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a href="{{route('resource.list', $resource)}}"  rel="category" data-wpel-link="internal">{{ trans('resource::resource.function_name.'.$resource->template)}}</a>
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a  rel="category" data-wpel-link="internal">{{$resource->name}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-rounded-box" style="background: #f8f9fa" ></div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container">

            <!-- Doctor Widget -->
            <div class="p-3 card card-vertical show-resource-detail-holder bg-cover-08">
                <div class="avatar avatar-xxl">
                    <img width="300px" src="{{$resource->getProfile()}}" class="rounded avatar-img" alt="{{$resource->name}}">
                </div>
                <div class="card-body">
                    <div class="doctor-widget">
                        <div class="doc-info-left">
                            <div class="pl-3 doc-info-cont">
                                <h4 class="doc-name">{{ $resource->name }}</h4>
                                <p class="doc-speciality">
                                    @if($resource->caption)<span class="mr-4">{{ $resource->caption }}</span> @endif
                                    @if($resource->ostan and $resource->shahrestan)<span><i class="la la-map-marker" ></i>{{ $resource->ostan->name }}, {{ $resource->shahrestan->name }}</span>@endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Doctor Widget -->

            <div class="row">
                <div class="col-md-8">
                    <div clas="card-body pt-0">
                        @if (sizeof($services))
                        <!-- Services List -->
                        <div class="card search-filter">
                            <div class="justify-between card-header d-flex" style="border-top: 3px solid #1abbcc;">
                                <h4 class="mb-0 card-title font-weight-bold line-e">خدمات</h4>
                            </div>
                            <div class="card-body ">
                                <div class="service-list">
                                    <ul class="clearfix">
                                        @foreach ($services as $item)
                                        <li><a href="{{$item->path()}}">{{$item->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /Services List -->
                        @endif

                        <!-- About Details -->

                        <div class="card search-filter">
                            <div class="justify-between card-header d-flex" style="border-top: 3px solid #1abbcc;">
                                <h4 class="mb-0 card-title font-weight-bold line-e">درباره</h4>
                            </div>
                            <div class="card-body ">
                                {!! $resource->bio !!}
                            </div>
                        </div>
                        <!-- /About Details -->

                    </div>


                </div>
                <div class="col-md-4">

                    <div class="card search-filter">
                        <div class="justify-between card-header d-flex" style="border-top: 3px solid #b1cc1a;">
                            <h4 class="mb-0 card-title font-weight-bold line-e"><i class="la la-map-marker"></i> اطلاعات تماس</h4>

                        </div>
                        <div class="p-0 card-body">
                            <div class="p-0 mb-0 filter-widget" x-data="{items: true}">
                                <h4 class="justify-between font-weight-bold d-flex active">
                                    <span>آدرس</span>
                                </h4>
                                <div class="filter-holder" x-show="items">
                                {!! $resource->address !!}
                                </div>
                            </div>
                            <div class="p-0 mb-0 filter-widget" x-data="{items: true}">
                                <h4 class="justify-between font-weight-bold d-flex active">
                                    <span>تلفن تماس</span>
                                </h4>
                                <div class="filter-holder" x-show="items">
                                {{ $resource->phone }}
                                </div>
                            </div>
                                <style>
                                    #map { height: 180px; }
                                    .leaflet-popup-content {
                                        font-family: 'iransans-ulight';
                                        text-align: center;
                                    }
                                    .leaflet-bottom.leaflet-right {
                                        display: none;
                                    }

                                </style>
                                @if($resource->lat and $resource->lon)
                                <div class="p-0 mb-0 filter-widget" x-data="{items: true}">
                                    <h4 class="justify-between font-weight-bold d-flex active">
                                        <span>نقشه</span>
                                    </h4>
                                    <div class="filter-holder" id="map" x-show="items">
                                    </div>

                                    <script >
                                        document.addEventListener("turbolinks:load", function() {
                                            var map = L.map('map').setView([{{$resource->lat}}, {{$resource->lon}}], 15);
                                            var tiles = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                                                attribution: 'gariin.com',
                                                maxZoom: 18,
                                                id: "mapbox.streets",
                                            }).addTo(map);

                                            var marker = L.marker([{{$resource->lat}}, {{$resource->lon}}]).addTo(map);
                                            marker.bindPopup("<b>{{$resource->name}}</b><br>").openPopup();
                                        })
                                    </script>
                                </div>
                                @endif
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
    <!-- /Page Content -->

    <script>
    </script>



    <script>



    </script>


</div>
