'use strict';
$(function(){
    // nav tips
    if ( ! utils.isMobileClient()) {
        $('nav a i').tipsy({
            gravity: 'n',
            opacity: 0.6,
            offset: 3
        });
    }

    // notifications
    $.amaran({
        'message': 'Tips: 试试话题与参与人的多重检索吧~',
        'position': 'top right',
        'inEffect': 'slideRight',
        'outEffect': 'slideRight',
        'sticky': true
    });
});
