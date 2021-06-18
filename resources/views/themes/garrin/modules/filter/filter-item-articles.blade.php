<div>

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-color-0 bg-svg-01">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="post-show-top-widget-box">
                    <div class="blog-single-categories-holder">
                        <div class="blog-single-categories">
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a href="{{ url('/') }}" ><i class="fa fa-home blog-item-popular"></i></a>
                            <a href="{{$filterItem->filter->path()}}" rel="category" data-wpel-link="internal">{{$filterItem->filter->name}}</a>
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a href="{{$filterItem->path()}}" rel="category" data-wpel-link="internal">{{$filterItem->name}}</a>
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a rel="category" data-wpel-link="internal">{{$filterItem->articles_title}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-rounded-box" style="background: #f8f9fa" ></div>
    <!-- /Breadcrumb -->

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                
                    <div class="row blog-grid-row">    
                        @foreach ($posts as $item)
                            @php
                                $item = $item->withFakes();
                            @endphp
                            <div class="col-md-4 col-sm-6 col-12">
                                <!-- Blog Post -->
                                <div class="card flex-fill rounded-3xl">
                                    <div class="blog-image card-img-top">
                                        <a href="{{$item->path()}}"><img class="img-fluid" src="{{asset($item->image)}}" alt="{{$item->title}}"></a>
                                    </div>
                                    <div class="p-3 blog-content grid-blog">
                                        <ul class="entry-meta meta-item">
                                            <li>
                                                <div class="post-author">
                                                    {{-- <a href="{{$item->user->path()}}"><img src="{{$item->user->getProfile()}}" alt="{{$item->user->name}}"> <span>{{$item->user->name}}</span></a> --}}
                                                </div>
                                            </li>
                                            <li class="color-second"><i class="far fa-clock"></i> {{$item->date()}}</li>
                                        </ul>
                                        <h3 class="blog-title"><a href="{{$item->path()}}">{{$item->title}}</a></h3>
                                        <p class="mb-0">{{\Illuminate\Support\Str::limit($item->description, 125)}}</div>
                                </div>
                                <!-- /Blog Post -->
                            </div>
                        @endforeach   
                        @if (sizeOf($posts) === 0)
                        <img class="d-block" style="width:150px; margin:20px auto;" src="{{asset('/uploads/images/themes/garrin/page-not-found.svg')}}">
                        <p class="pb-3 mb-3 text-center d-block w-100 font-weight-bold">هنوز مطلبی در این بخش ایجاد نشده است.</p>
                        @endif
                    </div>
                    <!-- Blog Pagination -->
                    <div class="row">
                        <div class="col-md-12">
                            {{ $posts->links('theme::partials.pagination') }}
                        </div>
                    </div>
                    <!-- /Blog Pagination -->
                </div>
            </div>    
        </div>
    </div>	
</div>
