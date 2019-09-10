$(document).ready(function () {
    var url = document.location.href;
    var actionName = url.substring(url.lastIndexOf("=") + 1, url.length);
    //$('li').each(function(){
       if($('li').Attr('id') = actionName){
            $('li').addClass('active');
          } 
        else{
            $('li').removeClass('active');
        }
    //});
});
