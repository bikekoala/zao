'use strict';
var utils = {
    isMobileClient : function() {
        return 768 >= $(window).width();
    },
    isWinOs : function() {
        return navigator.userAgent.indexOf('Windows', 0) != -1;
    },
    emoji : function() {
        var emoji = new EmojiConvertor();
        emoji.init_env();
        emoji.img_sets = {'apple': {'path': '/static/module/js-emoji/emoji-data/img-apple-64/'}};
        emoji.img_set = 'apple';
        emoji.replace_mode = 'img';
        emoji.supports_css = false;
        emoji.include_title = true;
        return emoji;
    }
};

$.fn.wait = function(func, times, interval) { 
    var _times = times || -1,
        _interval = interval || 20,
        _self = this,
        _selector = this.selector,
        _iIntervalID;
    if ( this.length ) {
        func && func.call(this);
    } else {
        _iIntervalID = setInterval(function() {
            if ( ! _times) {
                clearInterval(_iIntervalID);
            }
            _times <= 0 || _times--;

            _self = $(_selector);
            if (_self.length) {
                func && func.call(_self);
                clearInterval(_iIntervalID);
            }
        }, _interval);
    }
    return this;
}
