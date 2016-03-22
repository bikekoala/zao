@extends('layouts.default')

@section('content')
<div id="player"></div>
<h1 class="post-title">关于</h1>
<div class="post-about">
    <p>你好！朋友！这里是飞鱼秀的非官方回放网站，赶紧扫描下方的二维码来拜见我们的舟舟国主吧！</p>
    <div class="qrcode">
        <img src="/static/img/qrcode_zaoaoaoaoao.jpg">
        <img src="/static/img/qrcode_ezfeiyuxiu.jpg">
    </div>
</div>
<span id="contribute" class="post-about-contribute">
    由于待完善的节目话题和参与人信息数量巨大，单凭一己之力的话得做到猴年马月，所以还请我们飞鱼人一起完善。当你正在收听有空标题或空参与人的节目时，可以在下方回复：
    <br>
    <br>
    🐶 话题 🐶
    <br>
    🐰 小飞|喻舟 🐰
    <br>
    <br>
    用两只毛豆包住『话题』，用两只呆呆包住『参与人』，多个参与人用『 | 』分割，然后点击发布。此时我会收到一封邮件，几分钟后你所贡献的内容和花名就会出现在页面上啦~
</span>

<script src="/static/??js/about.js?v={{ env('STATIC_FILE_VERSION') }}"></script>
@endsection

@section('author')
<a href="https://github.com/popfeng/zao/blob/master/readme.md" target="_blank" class="link">@popfeng</a>
@endsection
