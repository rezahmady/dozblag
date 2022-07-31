const queryString = window.location.search;

const urlParams = new URLSearchParams(queryString);

if(urlParams.has('fields')) {
    const fields_str = urlParams.get('fields');
    const fields = fields_str.split(",");
    let repeatable = [];
    fields.forEach(field => {
        console.log(field)
        const sections = field.split(".");
        if(sections.length > 1) {
            $('body').css({minHeight: '500px'})
            repeatable[sections[0]] = sections[1];
            setTimeout(() => {
                $('div[bp-field-name="'+sections[0]+'"]').removeClass('d-none');
                $('.container-repeatable-elements div[data-repeatable-holder="'+sections[0]+'"]').find('.repeatable-element').addClass('d-none');
                $('.container-repeatable-elements div[data-repeatable-holder="'+sections[0]+'"]').find('*[data-row-number="'+sections[1]+'"]').removeClass('d-none');
                $('.container-repeatable-elements div[data-repeatable-holder="'+sections[0]+'"]').find('*[data-row-number="'+sections[1]+'"]').find('.form-group').removeClass('d-none');
            }, 1000);
        }
    })

    console.log(repeatable);
    $('.form-group').addClass('d-none');
    $('#saveActions').removeClass('d-none');
    $('.repeatable-element').find('.form-group').removeClass('d-none');
    crud.fields(fields).forEach(field => {
        if(field.type == 'repeatable') {
            $('body').css({minHeight: '500px'})
        }
        field.show();
    });

    const has_tab = document.getElementsByClassName('nav-tabs');
    if (has_tab.length > 0) {
        var content = '<div cass="row">';
    
        const tabs = document.getElementsByClassName("tab-pane");
    
        Array.prototype.forEach.call(tabs, function(tab) {
            // Do stuff here
            content = content.concat("\n", tab.getElementsByClassName("row")[0].innerHTML);
        });
        content = content.concat("\n", '</div>');
    
        $(".tab-pane.active")[0].innerHTML = content;
        $('.tab-pane').not(".active").remove();
    
        document.querySelector(".nav-tabs").classList.add("d-none");


        $('.main').removeClass('pt-2');

        $('.container-fluid').css({padding: '0'});
    }

} else {
    if (urlParams.has('iframe')) {
        const tab = document.getElementsByClassName("nav-tabs");
        if (tab.length > 0) {
            $('.nav-tabs').addClass('tab-sticky');
            $('.tab-pane').css({ marginTop: '50px' });
            $('#form_tabs').css({ top: '0' });
        }
    }
}