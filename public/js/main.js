$(function(){
    // go top
    $(window).scroll(function(){
        if($(window).scrollTop() > 200){
            $('#gotop').fadeIn(500);
        }else{
            $('#gotop').fadeOut(500);
        }
    });         
    $('#gotop').click(function(){
        $('body,html').animate({scrollTop:0},500);
        return false;
    });
});
