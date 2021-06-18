@section('meta_title')
{{ $post->meta_title ?? $post->title}}
@endsection

@section('meta_description')
{{ $post->meta_description}}
@endsection

@section('meta_keywords')
{{ $post->meta_keywords}}
@endsection
<div>
    <div class="blog-progress-head">
        <div class="progress-container">
            <div class="progress-bar" id="blog-content"></div>
        </div>
    </div>
    <style>
        body {
            background: #fff;
        }
    </style>
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar post-show-top-widget bg-svg-01">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="post-show-top-widget-box">
                    <div class="blog-single-categories-holder">
                        <div class="blog-single-categories">
                            <i class="fa fa-chevron-left blog-item-popular"></i>
                            <a href="{{ url('/') }}" ><i class="fa fa-home blog-item-popular"></i></a>
                            @foreach ($cats as $key => $item)
                                <a href="{{ $item->path() }}" rel="category" data-wpel-link="internal">{{ $item->name }}</a>
                                @if ($key +1 !== sizeOf($cats))
                                <i class="fa fa-chevron-left blog-item-popular"></i>
                                @endif
                            @endforeach
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <div class="top-rounded-box"></div>
    <!-- /Breadcrumb -->
    <!-- Page Content -->
    <div class="content blog-single ">
        
        <div class="blog-single" itemscope="" itemtype="http://schema.org/Article">
            <meta itemprop="mainEntityOfPage" content="{{ $post->path() }}">
            <div class="blog-single-image-holder" itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
                <img itemprop="url" alt="{{ $post->title }}" src="{{ url($post->image) }}">
            </div>
            <div class="blog-single-top-holder position-relative">
                {{-- @can('page update')
                    <a class="mb-5 button kt-modal-button button-info btn-setting" style="top:20px;right:20px" href="{{ url("/admin/widget/edit?iframe=true#bnr") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loader"></i> محتوا </a>
                @endcan --}}
                <h1 class="blog-single-title" itemprop="name headline">{{ $post->title }}</h1>
            </div>
            <div class="blog-single-content-holder">
                <div class="blog-single-content-sidebar">
                    <div class="">
                    
                        <div class="row">
                            <div class="col-lg-9 col-md-9">
                                <div class="blog-view blog-single-content">
                                    @php
                                        $list = (isset($post->list)) ? json_decode($post->list) : null;
                                    @endphp
                                    @if ($list)
                                    <div class="accordions accordion-items-closed" x-data="blogList()">
                                        <div class="accordion blog-single-headings-list"  :class="{ 'active': showList === true }" x-on:click="toggleShow()">
                                            <div class="accordion-title" :class="{ 'active': showList === true }">
                                                <i class="fa fa-list"></i>
                                                <h4 class="accordion-title-inner">فهرست مطالب</h4>
                                            </div>
                                            <div class="accordion-content" >
                                                <div class="accordion-content-inner">
                                                    <ul>
                                                        @foreach ($list as $item)
                                                            <li>
                                                                <a href="#{{ $item->hook ?? '' }}" >{{ $item->label ?? '' }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="blog blog-single-post">
                                        <div class="blog-content" itemprop="articleBody" >
                                            {!! $post->content !!}
                                        </div>
                                    </div>
                                    @php
                                        $resources = (isset($post->resources)) ? json_decode($post->resources) : null;
                                    @endphp
                                    @if ($resources)
                                    <div class="tags-widget">
                                        <div class="mt-1">
                                            <h4 class="section-title">منابع</h4>
                                        </div>
                                        <div class="">
                                            <ul class="link-list">
                                                @foreach ($resources as $item)
                                                    <li id="{{ $item->hook ?? null }}" ><a href="{{ $item->link ?? '#' }}" class="link">{{ $item->label ?? null }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @endif

                                    @php
                                        $tags = $post->tags;
                                    @endphp
                                    <!-- Tags -->

                                    @if ($tags)
                                        <div class="tags-widget">
                                            <div class="mt-3">
                                                <h4 class="section-title">برچسب‌ها</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="tags">
                                                    @foreach ($tags as $item)
                                                        <li><a href="{{$item->path()}}" class="tag">{{$item->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- /Tags -->
                                    <div class="clearfix mb-3 blog-goto-comments">
                                        <span>
                                            در بحث‌‌ پیرامون این مقاله شرکت کنید!                        </span>
                                        <a href="#blog-comments" class="button button-default">ارسال دیدگاه</a>
                                    </div>
                                    
                                    <div class="mb-5 row">
                                        <!-- Telegram -->
                                        <div class="mb-3 col-md-6 col-sm-6 pr-md-1">
                                            <a href="https://t.me/garrin" class="blog-single-social-box blog-single-social-box-telegram" data-wpel-link="external" target="_blank" rel="nofollow external noopener">
                                                <div class="blog-single-social-box-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path d="M385.268 121.919l-210.569 129.69c-11.916 7.356-17.555 21.885-13.716 35.323l22.768 80c1.945 6.821 8.015 11.355 14.999 11.355.389 0 .782-.014 1.176-.043 7.466-.542 13.374-6.103 14.367-13.515l5.92-43.866a25.915 25.915 0 018.001-15.45l173.765-161.524a13.817 13.817 0 001.618-18.545 13.836 13.836 0 00-18.329-3.425zM214.32 290.478a46.364 46.364 0 00-14.323 27.655l-2.871 21.278-16.527-58.072c-1.343-4.704.635-9.791 4.805-12.365l154.258-95.007L214.32 290.478z"></path>
                                                        <path d="M503.67 37.382a23.52 23.52 0 00-23.698-4.005L15.08 212.719C5.873 216.27-.047 224.939 0 234.804c.048 9.874 6.055 18.495 15.316 21.965l108.59 40.529 42.359 136.225a23.517 23.517 0 0015.703 15.566 23.49 23.49 0 0021.66-4.31l63.14-51.473a8.642 8.642 0 0110.528-.295l113.883 82.681a23.476 23.476 0 0013.823 4.511 23.6 23.6 0 008.517-1.596c7.486-2.895 12.93-9.312 14.56-17.163l83.429-401.309a23.547 23.547 0 00-7.838-22.753zM491.536 55.99l-83.428 401.308c-.302 1.45-1.346 2.053-1.942 2.284-.6.232-1.785.489-2.997-.393l-113.887-82.685a28.982 28.982 0 00-17.052-5.531 29.013 29.013 0 00-18.347 6.519l-63.154 51.485c-1.124.92-2.291.756-2.885.577-.598-.18-1.665-.69-2.099-2.086L141.9 286.462a10.203 10.203 0 00-6.173-6.527L22.462 237.662c-1.696-.635-2.057-1.958-2.062-2.957-.005-.99.343-2.307 2.023-2.955L487.316 52.409l.008-.003c1.51-.583 2.627.087 3.159.537.534.455 1.384 1.455 1.053 3.047z"></path>
                                                        <path d="M427.481 252.142c-5.506-1.196-10.936 2.299-12.131 7.804l-1.55 7.14c-1.195 5.505 2.299 10.936 7.804 12.131a10.25 10.25 0 002.174.234c4.695 0 8.92-3.262 9.958-8.037l1.55-7.14c1.194-5.505-2.301-10.936-7.805-12.132zm-10.2 46.98c-5.512-1.195-10.938 2.299-12.132 7.804L381.69 414.977c-1.195 5.505 2.299 10.936 7.803 12.131.73.158 1.457.234 2.174.234 4.696 0 8.92-3.262 9.958-8.037l23.459-108.052c1.195-5.505-2.299-10.936-7.803-12.131z"></path>
                                                    </svg>
                                                </div>
                                                <div class="blog-single-social-box-text">در <b>تلگرام</b><br>گرین را دنبال کنید!</div>
                                            </a>
                                        </div>
                                        <!-- /Telegram -->

                                        <!-- Instagram -->
                                        <div class="mb-3 col-md-6 col-sm-6 pl-md-1">
                                            <a href="https://www.instagram.com/f" class="blog-single-social-box blog-single-social-box-instagram" data-wpel-link="external" target="_blank" rel="nofollow external noopener">
                                                <div class="blog-single-social-box-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path d="M362 44H150C91.551 44 44 91.551 44 150v212c0 58.449 47.551 106 106 106h61c5.523 0 10-4.477 10-10s-4.477-10-10-10h-61c-47.42 0-86-38.58-86-86V150c0-47.42 38.58-86 86-86h212c47.42 0 86 38.58 86 86v212c0 47.42-38.58 86-86 86h-60.333c-5.523 0-10 4.477-10 10s4.477 10 10 10H362c58.449 0 106-47.551 106-106V150c0-58.449-47.551-106-106-106z"></path>
                                                        <path d="M263.07 450.93c-1.86-1.86-4.44-2.93-7.07-2.93s-5.21 1.07-7.07 2.93S246 455.37 246 458s1.07 5.21 2.93 7.07S253.37 468 256 468s5.21-1.07 7.07-2.93c1.86-1.86 2.93-4.44 2.93-7.07s-1.07-5.21-2.93-7.07zm-87.24-295.22c-3.777-4.03-10.104-4.236-14.135-.461l-.443.417c-4.017 3.79-4.201 10.119-.41 14.136a9.97 9.97 0 007.275 3.137 9.966 9.966 0 006.861-2.727l.391-.367c4.03-3.776 4.237-10.105.461-14.135z"></path>
                                                        <path d="M256 118c-21.964 0-43.824 5.291-63.217 15.301-4.907 2.533-6.832 8.565-4.299 13.473 2.534 4.907 8.566 6.831 13.473 4.299C218.762 142.398 236.945 138 256 138c65.065 0 118 52.935 118 118s-52.935 118-118 118-118-52.935-118-118c0-20.419 5.295-40.537 15.313-58.178 2.727-4.802 1.045-10.906-3.758-13.634-4.803-2.726-10.906-1.045-13.634 3.758C124.197 208.592 118 232.125 118 256c0 76.093 61.907 138 138 138s138-61.907 138-138-61.907-138-138-138z"></path>
                                                        <path d="M256 166c-49.626 0-90 40.374-90 90s40.374 90 90 90 90-40.374 90-90-40.374-90-90-90zm0 160c-38.598 0-70-31.402-70-70s31.402-70 70-70 70 31.402 70 70-31.402 70-70 70zM387.25 86.75c-20.953 0-38 17.047-38 38s17.047 38 38 38 38-17.047 38-38-17.047-38-38-38zm0 56c-9.925 0-18-8.075-18-18s8.075-18 18-18 18 8.075 18 18-8.075 18-18 18z"></path>
                                                    </svg>
                                                </div>
                                                <div class="blog-single-social-box-text">در <b>اینستاگرام</b><br>گرین را دنبال کنید!</div>
                                            </a>
                                        </div>
                                        <!-- /Instagram -->
                                    </div>

                                    
                                    
                                    {{-- <div class="clearfix author-widget">
                                        <h4 class="section-title bottom-dashed-border">درباره نویسنده</h4>
                                        
                                        <div class="card-body">
                                            <div class="about-author">
                                                <div class="about-author-img">
                                                    <div class="author-img-wrap">
                                                        <a href="{{$post->user->path()}}"><img class="img-fluid rounded-circle" alt="{{ $post->user->name }}" src="{{$post->user->getProfile()}}"></a>
                                                    </div>
                                                </div>
                                                <div class="author-details">
                                                    <a  itemprop="author" href="{{$post->user->path()}}" class="blog-author-name">{{ $post->user->name }}</a>
                                                    <p class="mb-0">{{ $author->bio }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <!-- Latest Posts -->
                                    <hr>
                                    {{-- <h4 class="mt-3 section-title">مطالب مشابه </h4>
                                    <div class="card post-widget rounded-3xl">
                                        <div class="">
                                            <ul class="latest-posts">
                                                <li>
                                                    <div class="post-thumb">
                                                        <a href="blog-details.html">
                                                            <img class="img-fluid" src="assets/garrin/img/blog/blog-thumb-01.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-info">
                                                        <h4>
                                                            <a href="blog-details.html"> سؤال - بازدید از کلینیک به راحتی </a>
                                                        </h4>
                                                        <p>4 مهر 1399</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="post-thumb">
                                                        <a href="blog-details.html">
                                                            <img class="img-fluid" src="assets/garrin/img/blog/blog-thumb-02.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-info">
                                                        <h4>
                                                            <a href="blog-details.html"> فواید رزرو آنلاین پزشک چیست؟ </a>
                                                        </h4>
                                                        <p>3 مهر 1399</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="post-thumb">
                                                        <a href="blog-details.html">
                                                            <img class="img-fluid" src="assets/garrin/img/blog/blog-thumb-03.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-info">
                                                        <h4>
                                                            <a href="blog-details.html"> مزایای مشاوره با پزشک آنلاین </a>
                                                        </h4>
                                                        <p>3 مهر 1399</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="post-thumb">
                                                        <a href="blog-details.html">
                                                            <img class="img-fluid" src="assets/garrin/img/blog/blog-thumb-04.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-info">
                                                        <h4>
                                                            <a href="blog-details.html"> 5 دلیل عالی برای استفاده از یک دکتر آنلاین </a>
                                                        </h4>
                                                        <p>2 مهر 1399</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="post-thumb">
                                                        <a href="blog-details.html">
                                                            <img class="img-fluid" src="assets/garrin/img/blog/blog-thumb-05.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-info">
                                                        <h4>
                                                            <a href="blog-details.html"> برنامه زمان بندی قرار ملاقات پزشک آنلاین </a>
                                                        </h4>
                                                        <p>1 مهر 1399</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div> --}}
                                     <!-- /Latest Posts -->

                                </div>
                            </div>
                        
                            <!-- Blog Sidebar -->
                            <div class="col-lg-3 col-md-3 sidebar-right theiaStickySidebar">
                                <div class="clearfix blog-info">
                                    <div class="post-left">
                                        <ul>
                                        
                                            <li class="p-3"><i class="far fa-calendar"></i>{{$post->date()}}</li>
                                        </ul>
                                    </div>
                                </div>     
                                <div class="sharethis-sticky-share-buttons"></div>
                                <div class="sticky clearfix blog-share">
                                    <div class="card-body">
                                        <livewire:article.share-holder :view="'theme::partials.blog.share-holder'" :article="$post" />
                                    </div>
                                </div>

                            </div>
                            <!-- /Blog Sidebar -->
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="newsletter-holder" id="blog-comments">
                <div class="wrapper">
                    <div class="newsletter-inner">
                        <h3 class="align-center newsletter-title">دیدگاه ها</h3>
                        <div class="align-center newsletter-text"><p> در بحث‌‌ پیرامون این مقاله شرکت کنید.</p></div>
                    </div>
                </div>
            </div>
            <livewire:comment.comment-holder :module="$post" :view="'theme::partials.comment.blog-comments'"/>
        </div>
    </div>		
    <!-- /Page Content -->
    <livewire:article.share-holder :view="'theme::partials.blog.share-holder'" :article="$post" :class="'fixed d-md-none d-lg-none d-sm-flex'" />

    <script>
        function blogList() {
            return {
                showList: false,
                toggleShow() {
                    this.showList = ! this.showList;
                }
            }
        }

        var $root = $('html, body');

        $('a[href^="#"]').click(function() {
            console.log($.attr(this, 'href'));
            $root.animate({
                scrollTop: $($.attr(this, 'href')).offset().top
            }, 500);

            return false;
        });
    </script>
</div>