<div>

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-color-0">
        <div>
            <div class="doctor-book-card-content tile-card-content-1" style="background-image: linear-gradient(#2dff94bd, #00ffe782)"></div>
        </div>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="post-show-top-widget-box">
                    <div class="blog-single-categories-holder">
                        <div class="blog-single-categories">
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a href="{{ url('/') }}" ><i class="fa fa-home blog-item-popular"></i></a>
                            <a rel="category" data-wpel-link="internal">{{$filter->name}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-rounded-box" style="background: #f8f9fa" ></div>
    <!-- /Breadcrumb -->

    <div class="mb-5 content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                
                    <div class="row blog-grid-row justify-content-center">    
                        @foreach ($filterItems as $item)
                            @php
                                $item = $item->withFakes();
                                $image = ($item->image) ? url($item->image) : '';
                            @endphp
                            <div class="mb-3 col-lg-2 col-md-3 col-sm-4 col-6">
                                <!-- Slider Item -->
                                <div class="text-center speicality-item position-relative">
                                    <div class="speicality-img">
                                        <img src="{{url($image)}}" class="img-fluid" alt="Speciality">
                                    </div>
                                    <a class="pt-3 pb-2 d-block" href="{{ $item->path() }}">{{$item->name}}</a>
                                </div>
                                <!-- /Slider Item --> 
                            </div>
                        @endforeach   
                        @if (sizeOf($filterItems) === 0)
                        <img class="d-block" style="width:150px; margin:20px auto;" src="{{asset('/uploads/images/themes/garrin/page-not-found.svg')}}">
                        <p class="pb-3 mb-3 text-center d-block w-100 font-weight-bold">هنوز مطلبی در این بخش ایجاد نشده است.</p>
                        @endif
                    </div>
                    
                </div>
            </div>    
        </div>
    </div>	
</div>
