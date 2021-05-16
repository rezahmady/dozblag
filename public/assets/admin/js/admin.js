if (window.location.search === '?iframe=true') {
    $('.app-header').css({ display: 'none' });
    $('.sidebar.sidebar-pills').css({ display: 'none' });
    $('.breadcrumb').css({ display: 'none' });
    $('main > section.container-fluid h2').css({ display: 'none' });
    // $('#saveActions').css({ position: 'fixed', bottom: '0' });
    // $('#saveActions').css({ background: '#fff' });
    document.querySelector("#saveActions").addEventListener('click', function() {
        parent.$('[data-lity-close]').trigger('click');
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
        });
});


// Echo.channel('private-consultation.added')
//     .listen('ConsultationAdded', (e) => {
//         console.log('ConsultationAdded');
//     });