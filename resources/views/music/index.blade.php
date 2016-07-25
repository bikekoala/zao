@extends('layouts.default')

@section('content')
<div class="intro">
    <div class="title">
        <div class="cate">
            <span>歌曲</span>
        </div>
        <h1 title="飞鱼秀的大歌单">飞鱼秀 の 大歌单</h1>
    </div> 
    <p>歌手：<span>{{ $artist_counts}} 名</span></p>
    <p>歌曲：<span>{{ $music_counts }} 首</span></p>
</div>

<table class="table-box">
    <caption># Top {{ $limit }} 歌手</caption>
    <tr class="title">
        <th>歌手</th>
        <th>播放次数</th>
    </tr>
    @foreach ($artists as $artist)
    <tr class="row">
        <td><a href="{{ URL('music/artist/' . $artist->id) }}">{{ $artist->name }}</a></td>
        <td>{{ $artist->counts }}</td>
    </tr>
    @endforeach
</table>

<table class="table-box">
    <caption># Top {{ $limit }} 歌曲</caption>
    <tr class="title">
        <th>歌曲</th>
        <th>歌手</th>
        <th>专辑</th>
        <th>播放次数</th>
    </tr>
    @foreach ($musics as $music)
    <tr class="row">
        <td><a href="{{ URL('music/' . $music->id) }}">{{ $music->title }}</a></td>
        <td>@foreach ($music->artists as $artist)<a href="{{ URL('music/artist/' . $artist->id) }}">{{ $artist->name }}</a> @endforeach</td>
        <td>{{ $music->album }}</td>
        <td>{{ $music->counts }}</td>
    </tr>
    @endforeach
</table>

<link rel="stylesheet" href="/static/??css/music.css?v={{ env('STATIC_FILE_VERSION') }}">
@endsection

@section('extra')
<a href="http://www.acrcloud.cn/" rel="nofollow" target="_blank" class="link">@音乐识别由 <span>ACRCloud</span> 提供</a>
@endsection
