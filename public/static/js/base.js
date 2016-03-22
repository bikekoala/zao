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
});
