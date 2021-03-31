<div>
    <script src="https://cdn.plyr.io/3.6.3/plyr.polyfilled.js"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.3/plyr.css" />
    
    <section class="courses-details-area pt-100 pb-70">
        <div class="container">
            <div class="courses-details-header">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="courses-title">
                            <h2 id="player-title">{{ $product->name }}</h2>
                            <p>{{ $product->caption }}</p>
                        </div>
    
                    </div>
    
                </div>
            </div>
    
            <div class="row">
                <div class="col-lg-8">
                    <div class="courses-details-image text-center">
                        @if ($video)
                        <video src="{{ url($video) }}" style="width: 100%;" id="player" playsinline controls data-poster="{{ $image }}">
                            {{-- <source  type="video/mp4" /> --}}
                        </video>
                        @else
                        <img src="{{ $image }}" alt="{{ $product->name }}">
                        @endif
                    </div>
    
                    <div class="courses-details-desc">
                        {!! $product->description !!}

                        ‌@if ($product->template === 'course')
                            <h3>ویدئو‌های دوره</h3>
                            <div class="courses-accordion">
                                @php
                                    $course_grouped = [];
                                    foreach ($product->courses as $course) {
                                        $course_grouped[$course->section][] = $course;
                                    }
                                @endphp
                                <ul class="accordion">
                                    @foreach ($course_grouped as $section => $group)
                                    <li class="accordion-item">
                                        
                                        <a class="accordion-title @if($loop->first) active @endif " href="javascript:void(0)">
                                            <i class='bx bx-chevron-down'></i>
                                            {{ $section }}
                                        </a>
        
                                        <div class="accordion-content @if($loop->first) show @endif">
                                            <ul class="courses-lessons">
                                                @foreach ($group as $key => $item)
                                                <li class="single-lessons">
                                                    <div class="d-md-flex d-lg-flex align-items-center">
                                                        <span class="number">{{ $key+1 }}.</span>
                                                        
                                                        <a href="#" wire:click.prevent="$emit('initVideo','{{ $item->file }}')  class="lessons-title">{{ $item->title }}</a>
                                                        
                                                    </div>
        
                                                    <div class="lessons-info">
                                                        <a href="{{ url('download?filename='.$item->file) }}" class="duration" data-toggle="tooltip" data-placement="top" title="دانلود فایل"><i class='bx bx-download'></i> دانلود</a>
        
                                                        <a href="/" wire:click.prevent="$emit('initVideo','{{ $item->file }}') class="attrachment-video" data-toggle="tooltip" data-placement="top" title="پخش"><i class='bx bx-play-circle'></i> پخش</a>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    @endforeach
        
                                </ul>
                            </div>
                        @endif
    
                        {!! $product->content !!}            
    
                    </div>
    
                    
                </div>
    
                <div class="col-lg-4">
                    <div class="courses-sidebar-information">
                        <ul>
                            <li>
                                <span><i class='bx bx-group'></i> دانشجویان:</span>
                                10
                            </li>
                            @if ($product->template === 'course')
                                @foreach ($product->parameters as $item)
                                <li>
                                    <span><i class='{{ $item->icon }}'></i> {{ $item->label }}</span>
                                    {{ $item->value }}
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<script>
   
    document.addEventListener('DOMContentLoaded', function () {
        
        Livewire.hook('component.initialized', (component) => {
            const player = new Plyr('#player');
        })
        
        // listen for the event
        window.livewire.on('urlChanged', param => {
            // pushing on the history by passing the current url with the param appended
            history.pushState(null, null, `${document.location.pathname}?v=${param.video}`);
            $('html, body').animate({
                scrollTop: $('#player-title').offset().top
            }, 800, function() {
                const player = new Plyr('#player');
                player.play();
            });
        });
        
    })
</script>