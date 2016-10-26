<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>早后台</title>
    <link href="/static/module//bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="/static/module/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="/static/module/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL('admin') }}">Zao Dashboard</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @if (isset($navs))
                        @foreach ($navs as $m => $item)
                            @if (isset($item['sub']))
                                <li class="dropdown @if ($m == $module) active @endif">
                                    <a href="{{ $item['path'] }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $item['display'] }} <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        @foreach ($item['sub'] as $sub)
                                            @if(isset($sub['other']) and 'divider' == $sub['other'])
                                                <li role="separator" class="divider"></li>
                                            @else
                                                <li><a href="{{ $sub['path'] }}">{{ $sub['display'] }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li @if ($m == $module) class="active" @endif><a href="{{ $item['path'] }}">{{ $item['display'] }}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ URL('admin/auth/login') }}">Login</a></li>
                        <!--li><a href="{{ URL('admin/auth/register') }}">Register</a></li-->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ URL('admin/auth/logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

</body>
</html>
