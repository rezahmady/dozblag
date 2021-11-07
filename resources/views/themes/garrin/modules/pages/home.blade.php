<div x-data="home_state()" x-init="init()">
    <!-- Header -->
    <livewire:partials.header />
    <!-- /Header -->

    <div>
        <style>
            .header-nav {
                background-color: transparent;
                position: absolute;
                top: 0;
                right: 0;
                left: 0;
                z-index: 1;
            }
        </style>
        <!-- Home Banner -->
        <livewire:widgets.search :widget="widget('home_search')" :view="'theme::widgets.home_search'" />
        <!-- /Home Banner -->
    
        <!-- Services gariin -->
        <section class="section home-tile-section position-relative">
            <div class="container-fluid">
                
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row">
                            <livewire:widgets.custom :widget="widget('service1')" :view="'theme::widgets.service'" />
                            <livewire:widgets.custom :widget="widget('service2')" :view="'theme::widgets.service'" />
                            <livewire:widgets.custom :widget="widget('service3')" :view="'theme::widgets.service'" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services gariin -->
    
        <!-- Filters -->
        <livewire:widgets.filter-item :widget="widget('filter_slide')" :view="'theme::widgets.filter_slide'" />
        <!-- Filters -->
    
        <!-- Popular Doctors -->
        <livewire:widgets.list-user :widget="widget('doctor_slide')" :view="'theme::widgets.doctor_slide'" />
        <!-- /Popular Doctors -->
    
    
        <!-- Consultation Banner -->
        <livewire:widgets.custom :widget="widget('consultation_banner')" :view="'theme::widgets.consultation_banner'" />
        <!-- /Consultation Banner -->
    
        <!-- Blog Section -->
        <livewire:widgets.custom :widget="widget('mag_grider')" :view="'theme::widgets.mag_grider'" />
        <!-- /Blog Section -->
    
        
        <!-- Popular Resources -->
        <livewire:widgets.custom :widget="widget('resource_slide')" :view="'theme::widgets.resource_slide'" />
        <!-- /Popular Resources -->
    
        <!-- Comment Section -->
        <livewire:widgets.custom :widget="widget('comment_slide')" :view="'theme::widgets.comment_slide'" />
        <!-- /Comment Section -->
        
    </div>
    
    <!-- Footer -->
    <livewire:partials.footer />
    <!-- /Footer -->
    <script>
        function home_state() {
            return {
                search: false,
                hidden_search() {
                    this.search = false;
                },
                show_search() {
                    this.search = true;
                },
                widget: @entangle('widget'),
                setwidget(widget) {
                    this.widget = widget;
                },
                init() {
                    $(document).on('lity:close', function(event, instance) {
                        Livewire.emit('update-widget');
                    });
                }
            }
        }
    </script>
</div>



