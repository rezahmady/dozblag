(function($) {
    "use strict";

    if ($(window).width() > 767) {
        if ($('.theiaStickySidebar').length > 0) {
            $('.theiaStickySidebar').theiaStickySidebar({
                // Settings
                additionalMarginTop: 30
            });
        }
    }

    // Select 
    if ($('.select').length > 0) {
        $('.select').select2({
            minimumResultsForSearch: -1,
            width: '100%'
        });
    }

    // $('#pricing_select input[name="rating_option"]').on('click', function() {
    //     if ($(this).val() == 'price_free') {
    //         $('#custom_price_cont').hide();
    //     }
    //     if ($(this).val() == 'custom_price') {
    //         $('#custom_price_cont').show();
    //     } else {}
    // });




})(jQuery);