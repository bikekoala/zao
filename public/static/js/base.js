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
    const notificationData = $.parseJSON($('#content').attr('data-notification'));
    const notificationId = $.cookie('notification_id');
    if (notificationId < notificationData.id) {
        $.amaran({
            'message': notificationData.message,
            'position': 'top right',
            'inEffect': 'slideRight',
            'outEffect': 'slideRight',
            'sticky': true
        });
        $.cookie('notification_id', notificationData.id, {expires: 365, path: '/'});
    }
    $.amaran({
        'message': 'test',
        'position': 'top right',
        'inEffect': 'slideRight',
        'outEffect': 'slideRight',
        'sticky': true
    });
});
