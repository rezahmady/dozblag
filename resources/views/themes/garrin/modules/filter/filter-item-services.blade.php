<div >
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-color-0 bg-svg-02">
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
                            <a rel="category" data-wpel-link="internal">{{$filterItem->services_title}}</a>
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
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

                    <!-- Search Filter -->
                    <div class="card search-filter rounded-3xl">
                        <div class="justify-between card-header d-flex">
                            <h4 class="mb-0 card-title font-weight-bold line-e"><i class="la la-filter"></i> فیلتر ها</h4>
                            @if ($filterShow)
                            <small class="filter-remove-btn font-weight-bold" wire:click="setNullFilterArray()">پاک کردن فیلترها</small>
                            @endif
                        </div>
                        <div class="p-0 card-body">
                            
                            <div class="p-0 mb-0 filter-widget" x-data="{items: true}">
                                <h4 class="justify-between font-weight-bold d-flex" x-on:click="items = !items" x-bind:class="{ 'active': items }">
                                    <span>جنسیت</span>
                                    <i class="la" x-bind:class="{'la-plus' : !items, 'la-minus' : items}"></i>
                                </h4>
                                <div class="filter-holder" x-show="items">
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox"  wire:model="filterarray.gender.mail">
                                            <span class="checkmark"></span> پزشک آقا
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" wire:model="filterarray.gender.fmail" >
                                            <span class="checkmark"></span> پزشک خانم
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Search Filter -->

                </div>
                <div class="col-md-12 col-lg-8 col-xl-9 position-relative doctor-widgets-holder">
                    <div class="pb-2 mb-3">
                        <h3 class="mb-0 card-title font-weight-bold line-e">
                            مشاوره آنلاین با بهترین متخصص {{ $filterItem->name }}
                        </h3>
                    </div>
                    {{-- <div class="card rounded-3xl">
                        <div class="card-body" style="padding: 0 26px;">
                            <ul class="nav nav-tabs nav-tabs-top">
                                <li class="nav-item"><a class="nav-link active" href="#top-tab2" data-toggle="tab">مشاوره</a></li>
                                <li class="nav-item"><a class="nav-link " href="#top-tab3" data-toggle="tab">اطلاعات</a></li>
                            </ul>
                        </div>
                    </div> --}}
                    @if (sizeOf($doctors) < 1)
                        <div>
                            <h3 class="p-3 text-center">رکوردی وجود ندارد</h3>
                            @if ($filterShow)
                            <small class="m-auto text-center filter-remove-btn font-weight-bold d-block" wire:click="setNullFilterArray()">پاک کردن فیلترها</small>
                            @endif
                        </div>
                    @endif
                    @foreach ($doctors as $doctor)
                    @php
                        $doctor = $doctor->withFakes();
                    @endphp
                    <!-- Doctor Widget -->
                    <div class="card rounded-3xl bg-cover-08">
                        <div class="card-body">
                            <div class="doctor-widget">
                                <div class="doc-info-left">
                                    <div class="doctor-img">
                                        <a href={{$doctor->path()}}" class="avatar avatar-xxl">
                                            <img src="{{$doctor->getProfile()}}" class="avatar-img rounded-circle" style="background: aliceblue;" alt="{{ $doctor->name }}">
                                        </a>
                                    </div>
                                    <div class="pl-3 doc-info-cont mb-3">
                                        <a href="{{$doctor->path()}}"><h4 class="doc-name">{{ $doctor->name }}</h4></a>
                                        <p class="doc-speciality">{{ $doctor->getSpecilty() }}</p>
                                        <div class="clini-infos">
                                            <ul>
                                                <li> نظام پزشکی: <span class="value">{{$doctor->medical_code}}</span></li>
                                                <li>تجربه: <span class="value">{{$doctor->experience}} سال</span> </li>
                                                {{-- <li>تعداد مشاوره: <span class="value">11664 سوال (در مدت 1 سال و 10 ماه )</span> </li> --}}
                                            </ul>
                                        </div>
        
                                    </div>
                                </div>
                                <div class="doc-info-right">
                                    <div class="clini-infos">
                                        {{-- <div class="rating">
                                            <div class="card-rating">
                                                <div class="num">
                                                <p>4.5</p>
                                                </div>
                                            </div>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star"></i>
                                            <span class="d-inline-block average-rating">7 نظر</span>
                                        </div> --}}
        
                                    </div>
                                    <div class="clinic-booking">
                                        <a class="apt-btn rounded-3xl" href="{{$doctor->path()}}">مشاوره با پزشک</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Doctor Widget -->

                    @endforeach
                    <!-- Blog Pagination -->
                    <div class="row">
                        <div class="col-md-12">
                            {{ $doctors->links('theme::partials.pagination') }}
                        </div>
                    </div>

                    <div  wire:loading class="loader-holder">
                        <div  class="loader-spiner-01"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->

    <script> 
    // Livewire.on('$refresh', () => { }) 
    window.addEventListener('scrollToTop', event => {
        window.scrollTo({ top: 15, left: 15, behaviour: 'smooth' })
    })

    document.addEventListener("turbolinks:load", function() {
        $(document).ready(function () {
            $('.filter-holder').niceScroll({
                autohidemode:'leave',
                cursorborder:'none',
                cursorcolor: '#cecece',
            });
        })
    })
    </script>
</div>