<footer class="footer">
    <div class="footer-top box-shadow border-button"></div>
    <!-- Footer Top -->
    <div class="footer-top bg-cover-08">
        <div class="container-fluid">
            <div class="row">
                <livewire:widgets.custom :widget="widget('footer_about_us')" :view="'theme::widgets.footer.footer_about_us'" />
                <livewire:widgets.custom :widget="widget('footer_menu1')" :view="'theme::widgets.menu.footer_menu'" />
                <livewire:widgets.custom :widget="widget('footer_menu2')" :view="'theme::widgets.menu.footer_menu'" />
                <livewire:widgets.custom :widget="widget('footer_contact_us')" :view="'theme::widgets.footer.footer_contact_us'" />
            </div>
        </div>
    </div>
    <!-- /Footer Top -->

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container-fluid">

            <!-- Copyright -->
            <div class="copyright bg-gradient-01">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <livewire:partials.custom :view="'theme::partials.copyright'" />
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <!-- Copyright Menu -->
                        <livewire:widgets.custom :widget="widget('footer_menu3')" :view="'theme::widgets.menu.footer_menu3'" />
                        <!-- /Copyright Menu -->
                    </div>
                </div>
            </div>
            <!-- /Copyright -->

        </div>
    </div>
    <!-- /Footer Bottom -->
    <livewire:widgets.custom :widget="widget('contact_icon')" :view="'theme::widgets.footer.contact_icon'" />
    <livewire:widgets.search :widget="widget('home_search')" :view="'theme::widgets.header_search'" />
</footer>
