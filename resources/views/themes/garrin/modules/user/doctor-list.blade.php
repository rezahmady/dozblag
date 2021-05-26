<div >
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-svg-02">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="post-show-top-widget-box">
                    <div class="blog-single-categories-holder">
                        <div class="blog-single-categories">
                            <i class="fa fa-chevron-left blog-item-popular"></i><i class="fa fa-home blog-item-popular"></i>
                                <a rel="category" data-wpel-link="internal">پزشکان</a>
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
                        <div class="card-header d-flex justify-between">
                            <h4 class="card-title font-weight-bold line-e mb-0"><i class="la la-filter"></i> فیلتر ها</h4>
                            @if ($filterShow)
                            <small class="filter-remove-btn font-weight-bold" wire:click="setNullFilterArray()">پاک کردن فیلترها</small>
                            @endif
                        </div>
                        <div class="card-body p-0">
                            
                            <div class="filter-widget p-0 mb-0" x-data="{items: true}">
                                <h4 class="font-weight-bold d-flex justify-between" x-on:click="items = !items" x-bind:class="{ 'active': items }">
                                    <span>جنسیت</span>
                                    <i class="la" x-bind:class="{'la-plus' : !items, 'la-minus' : items}"></i>
                                </h4>
                                <div class="filter-holder" x-show="items">
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox"  wire:model="filter.gender.mail">
                                            <span class="checkmark"></span> پزشک آقا
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" wire:model="filter.gender.fmail" >
                                            <span class="checkmark"></span> پزشک خانم
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @include('theme::partials.filters')
                        </div>
                    </div>
                    <!-- /Search Filter -->

                </div>

                <div class="col-md-12 col-lg-8 col-xl-9 position-relative">

                    @if (sizeOf($doctors) < 1)
                        <div>
                            <h3 class="text-center p-3">رکوردی وجود ندارد</h3>
                            @if ($filterShow)
                            <small class="filter-remove-btn font-weight-bold m-auto text-center d-block" wire:click="setNullFilterArray()">پاک کردن فیلترها</small>
                            @endif
                        </div>
                    @endif
                    @foreach ($doctors as $doctor)
                    @php
                        $doctor = $doctor->withFakes();
                    @endphp
                    <!-- Doctor Widget -->
                    <div class="card rounded-3xl bg-cover-06" style="background-position:right">
                        <div class="card-body">
                            <div class="doctor-widget">
                                <div class="doc-info-left">
                                    <div class="doctor-img">
                                        <a href={{route('doctor.show', ['user' => $doctor->id])}}" class="avatar avatar-xxl">
                                            <img src="{{$doctor->getProfile()}}" class="avatar-img rounded-circle" alt="User Image">
                                        </a>
                                    </div>
                                    <div class="doc-info-cont pl-3">
                                        <h4 class="doc-name">{{ $doctor->name }}</h4>
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
                                        <div class="rating">
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
                                        </div>
        
                                    </div>
                                    <div class="clinic-booking">
                                        <a class="apt-btn bg-svg-02" href="{{route('doctor.show', ['user' => $doctor->id])}}">مشاهده پروفایل</a>
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