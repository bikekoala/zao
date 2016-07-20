@extends('layouts.default')

@section('content')
<div class="intro">
    <div class="title">
        <div class="cate">
            <span>歌曲</span>
        </div>
        <h1 title="{{ $music->title }}">{{ $music->title }}</h1>
    </div>
    
    <p>歌手：@foreach ($music->artists as $artist)<a href="{{ URL('music/artist/' . $artist->id) }}">{{ $artist->name }}</a> @endforeach</p>
    @if ($music->album)
    <p>专辑：<span>{{ $music->album }}</span></p>
    @endif
    @if ($music->genres)
    <p>流派：<span>{{ str_replace('|', ' ', $music->genres) }}</span></p>
    @endif
    @if ($music->release_date)
    <p>发行日期：<span>{{ $music->release_date }}</span></p>
    @endif
    @if ($music->label)
    <p>唱片公司：<span>{{ $music->label }}</span></p>
    @endif
</div>
<div class="chart" id="chart" data='{!! json_encode($total) !!}'></div>
<table class="table-box">
    <tr class="title">
        <th>日期</th>
        <th>话题</th>
        <th>时段</th>
        <th>开始</th>
        <th>结束</th>
    </tr>
    @foreach ($music->programs as $pm)
    <tr class="row">
        <td><a href="{{ URL('program') . '/' . $pm->dates->id }}">{{ $pm->date }}</a></td>
        <td><a href="{{ URL('program') . '/' . $pm->dates->id }}">{{ $pm->topic }}</a></td>
        <td>{{ program_part_title($pm->pivot->program_part) }}</td>
        <td>{{ seconds_to_time($pm->pivot->start_sec) }}</td>
        <td>{{ seconds_to_time($pm->pivot->end_sec) }}</td>
    </tr>
    @endforeach
</table>

<link rel="stylesheet" href="/static/??css/music.css?v={{ env('STATIC_FILE_VERSION') }}">
<script src="/static/??module/echarts/echarts.min.js,js/music.js?v={{ env('STATIC_FILE_VERSION') }}"></script>
@endsection
