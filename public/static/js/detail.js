'use strict';
$(function(){
    // audio player
    $('video').mediaelementplayer({
        isVideo: false,
        alwaysShowControls: true,
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
    $('.post-title, .post-meta').tipsy({
        gravity: 'e',
        html: true,
        delayOut: 3000,
        opacity: 0.6,
        offset: 10
    });
    $('.post-title, .post-meta').each(function() {
        $(this).children('li').trigger('mouseover').trigger('mouseout');
    });
});
