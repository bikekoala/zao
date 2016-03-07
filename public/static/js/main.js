'use strict';
const utils = {
    isMobileClient : function() {
        return 768 >= $(window).width();
    }
};

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

    // tips
    if ( ! utils.isMobileClient()) {
        $('nav a i').tipsy({
            gravity: 'n',
            opacity: 0.6,
            offset: 3
        });
    }
});
