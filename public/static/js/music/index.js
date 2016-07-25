'use strict';
$(function() {
    var $caption = $('.table-box caption');
    var $alllink = $caption.children('a');
    $caption.hover(function() {
        $alllink.show();
    }, function() {
        $alllink.hide();
    });
});
