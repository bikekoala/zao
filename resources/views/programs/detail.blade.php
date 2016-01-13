@extends('layouts.default')

@section('head-static')
<link rel="stylesheet" href="/static/module/mediaelement/mediaelementplayer.css" />
<script src="/static/module/mediaelement/mediaelement-and-player.js"></script>
@endsection

@section('content')
<div id="player"></div>
<h1 class="post-title">古典音乐</h1>
<ul class="post-meta">
    <li>2015.08.07</li>
    <li>周五</li>
    <li>
        <a href="">小飞</a>
        <a href="">喻舟</a>
    </li>
</ul>
<div class="post-content">
    <p>资讯</p>
    <video width="80%" height="30" controls="controls" preload="none">
        <source src="http://7xpybb.com1.z0.glb.clouddn.com/2005/0201/audio.m3u8" />
    </video>

    <p>古典音乐a</p>
    <video width="80%" height="30" controls="controls" preload="none">
        <source src="http://audio.xmcdn.com/group7/M09/1B/D2/wKgDWlV2jJniYVixAIiITpHbUzY071.m4a" />
    </video>

    <p>古典音乐b</p>
    <video width="80%" height="30" controls="controls" preload="none">
        <source src="http://ip.h5.rb03.sycdn.kuwo.cn/31e2c8eaab1f9ae9e56bea0fe195d32a/5695fb9f/resource/a3/74/24/2142701219.aac" />
    </video>
</div>
<ul class="post-near">
    <li class="prev">前一天: <a href="/programs/20101010.html">印象深刻的人</a></li>
    <li class="next">后一天: <a href="/programs/20101010.html">天冷要回家</a></li>
</ul>
<script>
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
</script>
@endsection
