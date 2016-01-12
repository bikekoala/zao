@extends('layouts.default')

@section('content')
<div id="player"></div>
<h1 class="post-title">关于</h1>
<div class="post-about">
    <p>你好！朋友！这里是飞鱼秀的非官方回放网站，赶紧扫描下方的二维码来拜见我们小人国的国主吧！</p>
    <div class="qrcode">
        <img src="/static/img/qrcode_zaoaoaoaoao.jpg">
        <img src="/static/img/qrcode_ezfeiyuxiu.jpg">
    </div>
    <p>
        <a href="https://github.com/popfeng" target="_blank" class="link">@popfeng</a>
    </p>
</div>
@endsection
