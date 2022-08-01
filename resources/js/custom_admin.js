const queryString = window.location.search;

const urlParams = new URLSearchParams(queryString);

if (urlParams.has('iframe')) {
    $('.app-header').css({ display: 'none' });
    $('.sidebar.sidebar-pills').css({ display: 'none' });
    $('.breadcrumb').css({ display: 'none' });
    $('main > section.container-fluid h2').css({ display: 'none' });

    // remove paddings
    $('.main').removeClass('pt-2');
    $('.container-fluid').css({padding: '0'});

    // clean save button
    $('#btnGroupDrop1').parent().remove();
    $('.btn-success').html(`
    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
    <span data-value="save_and_edit">ذخیره</span>
    `)

    const actions = document.querySelector("#saveActions");
    actions.querySelector(".btn-default").addEventListener('click', function() {
        var event = new CustomEvent('widgetmodalclose')
        window.parent.window.dispatchEvent(event);
        return true;
    })
} else {
    /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
        if (document.getElementById("saveActions")) {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("saveActions").style.bottom = "0";
            } else {
                document.getElementById("saveActions").style.bottom = "-70px";
            }
            prevScrollpos = currentScrollPos;
        }
    }
}

document.addEventListener("DOMContentLoaded", function() {
    $(".loader").delay(1000).fadeOut("slow");
    $.when($("#overlayer").delay(1000).fadeOut("slow"))
        .done(function() {
            $('body').delay(1000).removeClass('h-100vh');
        }
    );
});