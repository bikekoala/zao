@extends('layouts.default')

@section('content')
<div class="intro">
    <div class="title">
        <div class="cate">
            <span>歌曲</span>
        </div>
        <h1>500 Miles</h1>
    </div>
    <p>歌手：<a href="">The Innocence Mission</a></p>
    <p>专辑：<span>Christ Is My Hope</span></p>
    <p>流派：<span>Country</span></p>
    <p>发行日期：<span>2000</span></p>
    <p>唱片公司：<span>LAMP</span></p>
</div>
<div class="chart" id="chart"></div>
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
        <td><a href="{{ URL('program/20160201/?test') }}">2010-10-10</a></td>
        <td><a href="{{ URL('program/20160201/?test') }}">国庆总结</a></td>
        <td>完整</td>
        <td>30:00</td>
        <td>35:00</td>
    </tr>
    @endforeach
</table>

<link rel="stylesheet" href="/static/??css/music.css?v={{ env('STATIC_FILE_VERSION') }}">
<script src="/static/??module/echarts/echarts.min.js,js/music.js?v={{ env('STATIC_FILE_VERSION') }}"></script>
@endsection
