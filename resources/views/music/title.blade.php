@extends('layouts.default')

@section('content')
<div class="intro">
    <div class="title">
        <div class="cate">
            <span>歌曲</span>
        </div>
        <h1>Don't Cry</h1>
    </div>
    <p>歌手：<a href="">Guns N' Roses</a></p>
    <p>专辑：<span>Greatest Hits</span></p>
</div>
<div class="chart" id="chart"></div>
<table class="programs">
    <tr class="title">
        <th>日期</th>
        <th>话题</th>
        <th>时段</th>
        <th>开始</th>
        <th>结束</th>
    </tr>
    @foreach ([1, 2, 3, 4, 5, 6, 7, 8] as $i => $item)
    <tr class="row">
        <td><a>2010-10-10</a></td>
        <td><a>国庆总结</a></td>
        <td>完整</td>
        <td>30:00</td>
        <td>35:00</td>
    </tr>
    @endforeach
</table>

<link rel="stylesheet" href="/static/??css/music/title.css?v={{ env('STATIC_FILE_VERSION') }}">
<script src="/static/??module/echarts/echarts.min.js,js/music/title.js?v={{ env('STATIC_FILE_VERSION') }}"></script>
@endsection
