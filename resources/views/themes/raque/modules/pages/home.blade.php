<div>
    <style>
        .single-categories-courses-item {
            padding: 30px 20px;
        }
        .lity-iframe .lity-container, .lity-youtube .lity-container, .lity-vimeo .lity-container, .lity-facebookvideo .lity-container, .lity-googlemaps .lity-container {
            width: 100%;
            max-width: 740px;
        }
    </style>
    <!-- Start Main Banner -->
    <livewire:widgets.custom :widget="widget('banner')" :view="'theme::widgets.banner'" />
    <!-- End Main Banner -->

    <!-- Start Funfacts Area -->
    <livewire:widgets.custom :widget="widget('counter')" :view="'theme::widgets.counter'" />
    <!-- End Funfacts Area -->

    <!-- Start Courses Area -->
    <livewire:widgets.list-grouped :widget="widget('course_grouped')" :view="'theme::widgets.course_grouped'" />
    <!-- End Courses Area -->

    <!-- Start Courses Categories Area -->
    <livewire:widgets.list-group :widget="widget('course_group')" :view="'theme::widgets.course_group'" />
    <!-- End Courses Categories Area -->


    <!-- Start Become Instructor & Partner Area -->
    <livewire:widgets.custom :widget="widget('kashi')" :view="'theme::widgets.kashi'" />
    <!-- End Become Instructor & Partner Area -->

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        Livewire.hook('component.initialized', (component) => {
            $(document).on('lity:close', function(event, instance) {
                setTimeout(() => {
                    Livewire.emit('lityClosed')
                }, 1000);
            }); 
        })

        Livewire.hook('message.processed', (el, component) => {
                       
            setTimeout(() => {
                // Course Grouped
                $(".shorting").mixItUp();
                // Odometer JS
                var odo = $(".odometer");
                odo.each(function() {
                    var countNumber = $(this).attr("data-count");
                    console.log($(this)[0]);
                    // $(this).html(countNumber);
                    var odPhone = new Odometer({
                        el: $(this)[0],
                    });
                    odPhone.update(countNumber);
                });

                var new_odo = document.querySelector('.new-odometer');  
            }, 1000);
                   
        })
    })
</script>

