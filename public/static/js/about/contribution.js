'use strict';
$(function() {
    // replace emoji to image
    if (utils.isWinOs()) {
        var emoji = utils.emoji();
        var elements = document.getElementsByClassName('emoji-related');
        for (var i = 0, n = elements.length; i < n; i++) {
            elements[i].innerHTML = emoji.replace_unified(elements[i].innerHTML);
        }
    }
});
