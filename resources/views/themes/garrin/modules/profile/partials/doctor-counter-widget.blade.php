<div class="row">
    <div class="col-md-12">
        <div class="card dash-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-4">
                        <div class="dash-widget dct-border-rht">
                            <div class="circle-bar circle-bar1">
                                <div class="circle-graph1" data-percent="75">
                                    <img src="{{asset('uploads/images/themes/garrin/icon-01.png')}}" class="" alt="patient">
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6> مراجعان کلی </h6>
                                <h3>1500</h3>
                                <p class="text-muted"> تا امروز </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-4">
                        <div class="dash-widget dct-border-rht">
                            <div class="circle-bar circle-bar2">
                                <div class="circle-graph2" data-percent="65">
                                    <img src="{{asset('uploads/images/themes/garrin/icon-02.png')}}" class="" alt="Patient">
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6> مراجعان امروز </h6>
                                <h3>160</h3>
                                <p class="text-muted">6 تیر 1398</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-4">
                        <div class="dash-widget">
                            <div class="circle-bar circle-bar3">
                                <div class="circle-graph3" data-percent="50">
                                    <img src="{{asset('uploads/images/themes/garrin/icon-03.png')}}" class="" alt="Patient">
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6>نوبت ها</h6>
                                <h3>85</h3>
                                <p class="text-muted">6 تیر 1398</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('custom-script')
        <!-- Circle Progress JS -->
        <script src="{{asset('assets/garrin/js/plugins/circle-progress.min.js')}}" defer></script>
        <script>
            document.addEventListener("turbolinks:load", function() {
    
                    function animateElements() {
                        $('.circle-bar1').each(function() {
                            var elementPos = $(this).offset().top;
                            var topOfWindow = $(window).scrollTop();
                            var percent = $(this).find('.circle-graph1').attr('data-percent');
                            var animate = $(this).data('animate');
                            if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                                $(this).data('animate', true);
                                $(this).find('.circle-graph1').circleProgress({
                                    value: percent / 100,
                                    size: 400,
                                    thickness: 30,
                                    fill: {
                                        color: '#da3f81'
                                    }
                                });
                            }
                        });
                        $('.circle-bar2').each(function() {
                            var elementPos = $(this).offset().top;
                            var topOfWindow = $(window).scrollTop();
                            var percent = $(this).find('.circle-graph2').attr('data-percent');
                            var animate = $(this).data('animate');
                            if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                                $(this).data('animate', true);
                                $(this).find('.circle-graph2').circleProgress({
                                    value: percent / 100,
                                    size: 400,
                                    thickness: 30,
                                    fill: {
                                        color: '#68dda9'
                                    }
                                });
                            }
                        });
                        $('.circle-bar3').each(function() {
                            var elementPos = $(this).offset().top;
                            var topOfWindow = $(window).scrollTop();
                            var percent = $(this).find('.circle-graph3').attr('data-percent');
                            var animate = $(this).data('animate');
                            if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                                $(this).data('animate', true);
                                $(this).find('.circle-graph3').circleProgress({
                                    value: percent / 100,
                                    size: 400,
                                    thickness: 30,
                                    fill: {
                                        color: '#1b5a90'
                                    }
                                });
                            }
                        });
                    }
    
                    if ($('.circle-bar').length > 0) {
                        animateElements();
                    }
                    $(window).scroll(animateElements);
            });
        </script>
    @endpush
</div>