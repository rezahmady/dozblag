const queryString = window.location.search;

const urlParams = new URLSearchParams(queryString);

if(urlParams.has('fields')) {
    const fields_str = urlParams.get('fields');
    const fields = fields_str.split(",");
    console.log(fields);
    $('.form-group').addClass('d-none');
    $('#saveActions').removeClass('d-none');
    crud.fields(fields).forEach(field => {
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
    
        document.querySelector(".nav-tabs").classList.add("d-none");

        $('.tab-content').css({ marginTop: '25px' });
    }

} else {
    if (urlParams.has('iframe')) {
        const tab = document.getElementsByClassName("nav-tabs");
        if (tab.length > 0) {
            $('.nav-tabs').addClass('tab-sticky');
            $('#form_tabs').css({ position: 'absolute' });
            $('#form_tabs').css({ top: '0' });
        }
    }
}