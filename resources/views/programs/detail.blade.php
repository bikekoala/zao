@extends('layouts.default')

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
    <audio src="http://audio.xmcdn.com/group7/M09/1B/D2/wKgDWlV2jJniYVixAIiITpHbUzY071.m4a" controls="controls"></audio>

    <p>古典音乐a</p>
    <audio src="http://audio.xmcdn.com/group7/M09/1B/D2/wKgDWlV2jJniYVixAIiITpHbUzY071.m4a" controls="controls"></audio>

    <p>古典音乐b</p>
    <audio src="http://audio.xmcdn.com/group7/M09/1B/D2/wKgDWlV2jJniYVixAIiITpHbUzY071.m4a" controls="controls"></audio>
</div>
<ul class="post-near">
    <li class="prev">前一天: <a href="/programs/20101010.html">印象深刻的人</a></li>
    <li class="next">后一天: <a href="/programs/20101010.html">天冷要回家</a></li>
</ul>
@endsection
