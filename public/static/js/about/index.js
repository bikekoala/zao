'use strict';
$(function() {
    // replace emoji to image
    if (utils.isWinOs()) {
        var emoji = utils.emoji();
        var contribute = document.getElementById('contribute');
        contribute.innerHTML = emoji.replace_unified(contribute.innerHTML);
    }
});
