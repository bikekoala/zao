var duoshuoQuery = {
    short_name: 'zaoaoaoaoao',
    sso: { 
        login: 'http://zaoaoaoaoao.com/duoshuo/login?callback=' + window.location.href,
        logout: 'http://zaoaoaoaoao.com/duoshuo/logout?callback=' + window.location.href
    }
};
(function() {
    var ds = document.createElement('script');
    ds.type = 'text/javascript';
    ds.async = true;
    ds.charset = 'UTF-8';
    ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
})();
