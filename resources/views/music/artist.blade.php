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
        <th>时段</th>
        <th>开始</th>
        <th>结束</th>
    </tr>
    {{--
    @foreach ($artist->programs => $program)
    <tr class="row">
        <td><a href="{{ URL('program') . '/' . $program->dates->id }}">{{ $program->date }}</a></td>
        <td><a href="{{ URL('program') . '/' . $program->dates->id }}">{{ $program->topic }}</a></td>
        <td>{{ program_part_title($program->pivot->program_part) }}</td>
        <td>{{ seconds_to_time($program->pivot->start_sec) }}</td>
        <td>{{ seconds_to_time($program->pivot->end_sec) }}</td>
    </tr>
    @endforeach
    --}}
</table>


<link rel="stylesheet" href="/static/??css/music.css?v={{ env('STATIC_FILE_VERSION') }}">
<script src="/static/??module/echarts/echarts.min.js,js/music.js?v={{ env('STATIC_FILE_VERSION') }}"></script>
@endsection
