/*
Author       : Reza Ahmadi Sabzevar
Template Name: garin - Sityno Template
Version      : 1.3
*/

(function($) {
    "use strict";

    var maxLength = 100;
    $('#review_desc').on('keyup change', function() {
        var length = $(this).val().length;
        length = maxLength - length;
        $('#chars').text(length);
    });

    // Date Time Picker

    if ($('.datetimepicker').length > 0) {
        $('.datetimepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                up: "fas fa-chevron-up",
                down: "fas fa-chevron-down",
                next: 'fas fa-chevron-right',
                previous: 'fas fa-chevron-left'
            }
        });
    }

    // Floating Label

    if ($('.floating').length > 0) {
        $('.floating').on('focus blur', function(e) {
            $(this).parents('.form-focus').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
    }



    // Tooltip

    if ($('[data-toggle="tooltip"]').length > 0) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // Add More Hours

    $(".hours-info").on('click', '.trash', function() {
        $(this).closest('.hours-cont').remove();
        return false;
    });

    $(".add-hours").on('click', function() {

        var hourscontent = '<div class="row form-row hours-cont">' +
            '<div class="col-12 col-md-10">' +
            '<div class="row form-row">' +
            '<div class="col-12 col-md-6">' +
            '<div class="form-group">' +
            '<label>زمان شروع</label>' +
            '<select class="form-control">' +
            '<option>-</option>' +
            '<option>12.00 قبل از ظهر</option>' +
            '<option>12.30 قبل از ظهر</option>' +
            '<option>1.00 قبل از ظهر</option>' +
            '<option>1.30 قبل از ظهر</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-6">' +
            '<div class="form-group">' +
            '<label>زمان پایان</label>' +
            '<select class="form-control">' +
            '<option>-</option>' +
            '<option>12.00 قبل از ظهر</option>' +
            '<option>12.30 قبل از ظهر</option>' +
            '<option>1.00 قبل از ظهر</option>' +
            '<option>1.30 قبل از ظهر</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-2"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>' +
            '</div>';

        $(".hours-info").append(hourscontent);
        return false;
    });

    // Content div min height set

    function resizeInnerDiv() {
        var height = $(window).height();
        var header_height = $(".header").height();
        var footer_height = $(".footer").height();
        var setheight = height - header_height;
        var trueheight = setheight - footer_height;
        $(".content").css("min-height", trueheight);
    }

    if ($('.content').length > 0) {
        resizeInnerDiv();
    }

    $(window).resize(function() {
        if ($('.content').length > 0) {
            resizeInnerDiv();
        }
    });

    // Date Range Picker
    if ($('.bookingrange').length > 0) {
        var start = moment().subtract(6, 'days');
        var end = moment();

        function booking_range(start, end) {
            var start = moment(start); // pass your date obj here.
            console.log(start.format('jYYYY/jM/jD'));

            var end = moment(end); // pass your date obj here.
            console.log(end.format('jYYYY/jM/jD'));

            $('.bookingrange span').html(start.format('jYYYY/jM/jD') + ' - ' + end.format('jYYYY/jM/jD'));
        }

        $('.bookingrange').daterangepicker({
            months: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
            startDate: start,
            endDate: end,
            ranges: {
                'امروز': [moment(), moment()],
                'دیروز': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'هفته گذشته': [moment().subtract(6, 'days'), moment()],
                'ماه گذشته': [moment().subtract(29, 'days'), moment()],
                'این ماه': [moment().startOf('month'), moment().endOf('month')],
                'ماه بعد': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "locale": {
                "format": "YYYY/M/D",
                "separator": " - ",
                "applyLabel": "اعمال",
                "cancelLabel": "انصراف",
                "fromLabel": "از",
                "toLabel": "تا",
                "customRangeLabel": "سفارشی",
                "weekLabel": "هف",
                "daysOfWeek": [
                    "ی",
                    "د",
                    "س",
                    "چ",
                    "پ",
                    "ج",
                    "ش"
                ],
                "monthNames": [
                    "ژانویه",
                    "فوریه",
                    "مارس",
                    "آوریل",
                    "می",
                    "ژوئن",
                    "جولای",
                    "آگوست",
                    "سپتامبر",
                    "اکتبر",
                    "نوامبر",
                    "دسامبر"
                ],
                "firstDay": 6
            }
        }, booking_range);

        booking_range(start, end);
    }
    // Chat

    var chatAppTarget = $('.chat-window');
    (function() {
        if ($(window).width() > 991)
            chatAppTarget.removeClass('chat-slide');

        $(document).on("click", ".chat-window .chat-users-list a.media", function() {
            if ($(window).width() <= 991) {
                chatAppTarget.addClass('chat-slide');
            }
            return false;
        });
        $(document).on("click", "#back_user_list", function() {
            if ($(window).width() <= 991) {
                chatAppTarget.removeClass('chat-slide');
            }
            return false;
        });
    })();

    //Increment Decrement Numberes
    var quantitiy = 0;
    $('.quantity-right-plus').click(function(e) {
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        $('#quantity').val(quantity + 1);
    });

    $('.quantity-left-minus').click(function(e) {
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        if (quantity > 0) {
            $('#quantity').val(quantity - 1);
        }
    });

    //Cart Click
    $("#cart").on("click", function(o) {
        o.preventDefault();
        $(".shopping-cart").fadeToggle();
        $(".shopping-cart").toggleClass('show-cart');
    });


    // Preloader

    $(window).on('load', function() {
        if ($('#loader').length > 0) {
            $('#loader').delay(350).fadeOut('slow');
            $('body').delay(350).css({ 'overflow': 'visible' });
        }
    })

})(jQuery);