<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ECharts">
    <title>飞鱼人签到地图 - 早</title>
    <link rel="stylesheet" href="/static/css/here.css">
    <!--[if lt IE 9]>
        <script src="http://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
        <script src="http://cdn.staticfile.org/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="canvas"></div>
    <div id="info">
        <div class="user" id="user">
            @if (empty($user))
            <img src="/static/img/felix.png" alt="头像" class="avatar">
            @else
            <img src="{{ $user->avatar_url }}" alt="头像" title="{{ $user->name }}" class="avatar">
            @endif
            <div class="tips hide" id="user-tips">
                <div class="arrow"></div>
                <ul class="inner">
                    @if (empty($user))
                    <li><a id="login" data-toggle="modal" data-target="#login-modal">登录</a></li>
                    @else
                    <li><a class="load-remote-modal" data-url="/heres">签到</a></li>
                    <li><a>自己</a></li>
                    @endif
                    <li role="separator" class="divider"></li>
                    @if ( ! empty($user))
                    <li><a href="/duoshuo/logout?callback=/here">登出</a></li>
                    @endif
                    <li><a href="/">首页</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="modal" id="login-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">社交账号登录</h4>
                </div>
                <div class="modal-body">
                    <div class="ds-login"></div>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="basic-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="/static/module/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/font-awesome.min.css">

    <script src="/static/module/echarts/echarts.min.js"></script>
    <script src="/static/module/echarts/map/china.js"></script>
    <script src="/static/module/jquery-2.1.4.min.js"></script>
    <script src="/static/module/bootstrap/js/bootstrap.min.js"></script>
    <script src="/static/js/duoshuo.js"></script>
    <script src="/static/js/here/map.js"></script>
</body>
</html>
