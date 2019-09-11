$(document).ready(function () {
    var url = document.location.href;
    var actionName = url.substring(url.lastIndexOf("=") + 1, url.length);
    $('.nav-item').each(function(){
        if($(this).attr('id') == actionName)
        {
            $(this).addClass('active');
        }
        else if ($(this).attr('id') != actionName && actionName != 'signInVerif')
        {
            $(this).removeClass('active');
        }
    });
});
