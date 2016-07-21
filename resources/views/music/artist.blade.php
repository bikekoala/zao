@extends('layouts.default')

@section('content')
<div class="intro">
    <div class="title">
        <div class="cate">
            <span>歌手</span>
        </div>
        <h1>{{ $artist->name }}</h1>
    </div>
</div>
<div class="chart" id="chart" data='{!! json_encode($total) !!}'></div>
<table class="table-box">
    <tr class="title">
        <th>歌曲</th>
        <th>歌手</th>
        <th>专辑</th>
        <th>流派</th>
        <th>发行日期</th>
        <th>唱片公司</th>
    </tr>
    @foreach ($artist->musics as $music)
    <tr class="row">
        <td><a href="{{ URL('music') . '/' . $music->id }}">{{ $music->title }}</a></td>
        <td>@foreach ($music->artists as $artist)<a href="{{ URL('music/artist/' . $artist->id) }}">{{ $artist->name }}</a> @endforeach</td>
        <td>{{ $music->album }}</td>
        <td>{{ str_replace('|', ' ', $music->genres) }}</td>
        <td>{{ $music->release_date }}</td>
        <td>{{ $music->label }}</td>
    </tr>
    @endforeach
</table>
<table class="table-box">
    <tr class="title">
        <th>日期</th>
        <th>话题</th>
    </tr>
    @foreach ($artist->programs as $program)
    <tr class="row">
        <td><a href="{{ URL('program') . '/' . $program->dates->id }}">{{ $program->date }}</a></td>
        <td><a href="{{ URL('program') . '/' . $program->dates->id }}">@if ($program->topic) {{ $program->topic }} @else 🐶🐶🐶🐶  @endif</a></td>
    </tr>
    @endforeach
</table>


<link rel="stylesheet" href="/static/??css/music.css?v={{ env('STATIC_FILE_VERSION') }}">
<script src="/static/??module/echarts/echarts.min.js,js/music.js?v={{ env('STATIC_FILE_VERSION') }}"></script>
@endsection

@section('extra')
<a href="http://www.acrcloud.cn/" rel="nofollow" target="_blank" class="link">@音乐识别由 <span>ACRCloud</span> 提供</a>
@endsection
