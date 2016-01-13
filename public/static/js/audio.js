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
