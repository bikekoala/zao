<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>{{ $title or '早' }} - 飞鱼秀非官方回放</title>
        <meta name="keywords" content="CRI EZFM EZMorning 飞鱼秀 小飞 喻舟" />
        <meta name="description" content="亲爱的飞鱼人，这里可以在线收听自2005年飞鱼秀开播以来的几乎所有的节目回放喔~" />
        <link type="text/plain" rel="author" href="/humans.txt" />
        <link rel="stylesheet" href="/static/??module/tipsy/tipsy.css,module/AmaranJS/css/amaran.min.css,css/font-awesome.min.css,css/main.css,css/amaran.css?v={{ env('STATIC_FILE_VERSION') }}">
        <script src="/static/??module/jquery-2.1.4.min.js,module/tipsy/jquery.tipsy.js,module/js-emoji/js/emoji.min.js,module/jquery.cookie.js,module/AmaranJS/js/jquery.amaran.min.js,js/common.js,js/base.js?v={{ env('STATIC_FILE_VERSION') }}"></script>
        <!--[if lt IE 9]>
            <script src="http://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="http://cdn.staticfile.org/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <header>
            <div class="sidebar">
                <img class="avatar" src="/static/img/avatar.png">
                <h2 class="description">再见飞鱼秀，不散的飞鱼人</h2>
                <form action="/" method="get" class="search">
                    <i class="fa fa-search"></i>
                    <input type="search" name="s" value="{{ $_GET['s'] or '' }}" placeholder="" autocomplete="off">
                </form>
                <nav>
                    <a href="/"><i class="fa fa-home" original-title="首页"></i></a>
                    <a href="/programs/{{ $app_program_date or '20040802' }}"><i class="fa fa-calendar-check-o" original-title="APP同期"></i></a>
                    <a href="/about"><i class="fa fa-about" original-title="关于"> </i></a>
                </nav>
            </div>
        </header>

        <div class="content" id="content" data-notification='{!! $notification or "{}" !!}'>

            @yield('content')

            <footer id="footer">
                © 2016 <a href="/">Zao~ao~ao~ao~ao.com</a> @yield('author')
            </footer>
        </div>

        <script type="text/javascript">
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-72733017-1', 'auto');
            ga('send', 'pageview');
        </script>
    </body>
</html>
