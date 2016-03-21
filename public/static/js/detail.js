'use strict';
$(function(){
    // audio player
    $('video').mediaelementplayer({
        isVideo: false,
		enableKeyboard: false,
        alwaysShowControls: true,
        alwaysShowHours: true,
        videoVolume:'horizontal',
        features: ['playpause','progress','current','duration','tracks','volume'],
        defaultSeekBackwardInterval: function(media) {
            return (media.duration * 0.02);
        },
        defaultSeekForwardInterval: function(media) {
            return (media.duration * 0.02);
        }
    });

    // tips
    if ( ! utils.isMobileClient()) {
        // bind tips
        $('.post-title, .post-meta').tipsy({
            gravity: 'e',
            html: true,
            delayOut: 5000,
            opacity: 0.6,
            offset: 10
        });

        // replace emoji to image in tips
        if (utils.isWinOs()) {
            var emoji = utils.emoji();
            $('.post-title, .post-meta').on('mouseover', function() {
                var tips = document.getElementsByClassName('tipsy-inner');
                for (var i = 0, n = tips.length; i < n; i++) {
                    tips[i].innerHTML = emoji.replace_unified(tips[i].innerHTML);
                }
            });
        }

        // trigger it
        $('.post-title, .post-meta li').each(function() {
            $(this).trigger('mouseover').trigger('mouseout');
        });
    }

    // set cookie
    $.cookie('program_date', $('article').attr('data-date'), {expires: 365, path: '/'});
});
