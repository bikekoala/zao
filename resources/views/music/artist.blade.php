@extends('layouts.default')

@section('content')
<div class="intro">
    <div class="title">
        <div class="cate">
            <span>歌手</span>
        </div>
        <h1>The Innocence Mission</h1>
    </div>
</div>
<div class="chart" id="chart"></div>
<table class="table-box">
    <tr class="title">
        <th>歌曲</th>
        <th>歌手</th>
        <th>专辑</th>
        <th>流派</th>
        <th>发行日期</th>
        <th>唱片公司</th>
    </tr>
    @foreach ([1, 2, 3, 4, 5, 6, 7, 8] as $i => $item)
    <tr class="row">
        <td><a href="{{ URL('music/1') }}">500 Miles</a></td>
        <td><a href="{{ URL('music/artist/1') }}">The Innocence Mission</a></td>
        <td>Christ Is My Hope</td>
        <td>Country</td>
        <td>2000</td>
        <td>LAMP</td>
    </tr>
    @endforeach
</table>
<table class="table-box">
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


<link rel="stylesheet" href="/static/??css/music.css?v={{ env('STATIC_FILE_VERSION') }}">
<script src="/static/??module/echarts/echarts.min.js,js/music.js?v={{ env('STATIC_FILE_VERSION') }}"></script>
@endsection
