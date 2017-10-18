@extends('layouts.default')

@section('content')
<article itemtype="http://schema.org/Article" data-date="{{ $program->dates->id }}">
    <h1 class="post-title" original-title="@if ($contributers['topic'])by <a @if ($contributers['topic']['url']) href='{{ $contributers['topic']['url'] }}' rel='nofollow' target='_blank' @else href='#' @endif>{{ $contributers['topic']['name'] }}</a>@else @if (empty($program->topic)) 🐶 话题🐶 @endif @endif">@if ($program->topic) {{ $program->topic }} @else 空 @endif @if ($program->dates->id == $appdate)（APP同期节目）@endif</h1>
    <ul class="post-meta" original-title="@if ($contributers['participants'])by <a @if ($contributers['participants']['url']) href='{{ $contributers['participants']['url'] }}' rel='nofollow' target='_blank' @else href='#' @endif>{{ $contributers['participants']['name'] }}</a>@else @if (empty($program->participants->toArray())) 🐰 参与人 | 参与人🐰 @endif @endif">
        <li>{{ str_replace('-', '.', $program->date) }}</li>
        <li>周{{ $program->dates->dayNum}}</li>
        @if ( ! $program->participants->isEmpty())
        <li>
            @foreach ($program->participants as $participant)
            <a>{{ $participant->name }}</a>
            @endforeach
        </li>
        @endif
        <li>
            <span id="post-view-counts">
                <i class="fa fa-spinner fa-spin"></i>
            </span>
            次收听
        </li>
    </ul>
    <div class="post-content">
        @foreach ($audios as $audio)
        <p>
            {{ program_part_title($audio->part) }}
            @if ($audio->download_url)
            （<a href="{{ $audio->download_url }}" rel="nofollow" target="_blank">下载</a>）
            @endif
        </p>
        <audio width="100%" controls>
            <source src="{{ $audio->url }}" />
        </audio>
        @endforeach
    </div>
    <div class="post-music">
        <table class="list">
            <tr class="title">
                <th>歌曲</th>
                <th>歌手</th>
                <th>专辑</th>
                <th class="column-other">时段</th>
                <th class="column-other">开始</th>
                <th class="column-other">结束</th>
            </tr>
            <tr><td class="gap"></td></tr>
            @foreach ($program->musics as $i => $music)
            <tr class="row">
                <td class="title-box">
                    <div class="cover-frame">
                        <div class="cover">
                            <img src="/static/img/music_gnr.jpg" alt="封图">
                            <div class="mask hide"></div>
                            <div class="play btn-bg play-bg hide" data-action="play"></div>
                            <div class="pause btn-bg pause-bg hide" data-action="pause"></div>
                        </div>
                    </div>
                    <a href="{{ URL('music/' . $music->id) }}" target="_blank">{{ $music->title }}</a>
                    <audio data-src="{{ qiniu_url($music->pivot->url) }}"></audio>
                </td>
                <td>
                    @foreach ($music->artists as $artist)
                    <a href="{{ URL('music/artist/' . $artist->id) }}" target="_blank">{{ $artist->name }}</a>
                    @endforeach
                </td>
                <td>{{ $music->album }}</td>
                <td class="column-other">{{ program_part_title($music->pivot->program_part) }}</td>
                <td class="column-other">{{ seconds_to_time($music->pivot->start_sec) }}</td>
                <td class="column-other">{{ seconds_to_time($music->pivot->end_sec) }}</td>
            </tr>
            @endforeach
        </table> 
    </div>
    <span class="post-contributers">
        @if ( ! empty($contributers['topic']) or ! empty($contributers['participants']))
            @if ( ! empty($contributers['topic']))
                ( 话题 by <a href="{{ $contributers['topic']['url'] }}" rel="nofollow" target="_blank">{{ $contributers['topic']['name'] }}</a> )
            @endif
            @if ( ! empty($contributers['participants']))
                ( 参与人 by <a href="{{ $contributers['participants']['url'] }}" rel="nofollow" target="_blank">{{ $contributers['participants']['name'] }}</a> )
            @endif
        @else
            @if (empty($program->topic) or $program->participants->isEmpty())
                ( 了解参与贡献内容的<a href="{{ URL('about') }}#contribute">方式</a> )
            @endif
        @endif
    </span>
    <ul class="post-near">
        @if ($pages->prev)
        <li class="prev">前一天: <a href="{{ URL('program') }}/{{ $pages->prev->dates->id }}">@if ($pages->prev->topic) {{ $pages->prev->topic }} @else 空 @endif</a></li>
        @endif
        @if ($pages->next)
        <li class="next">后一天: <a href="{{ URL('program') }}/{{ $pages->next->dates->id }}">@if ($pages->next->topic) {{ $pages->next->topic }} @else 空 @endif</a></li>
        @endif
    </ul>
</article>

<!--div class="ds-thread" data-thread-key="{{ $program->dates->id }}" data-title="{{ $program->date }} - {{ $program->topic }}" data-url="{{ Config::get('app.url') }}/program/{{ $program->dates->id }}"></div-->
@include('layouts.disqus')

<link rel="stylesheet" href="/static/module/mediaelement-4.2.6/build/mediaelementplayer.min.css">
<script src="/static/module/mediaelement-4.2.6/build/mediaelement-and-player.js"></script>

<link rel="stylesheet" href="/static/css/detail.css">
<script src="/static/js/detail.js"></script>

@endsection

@section('extra')
<a href="http://www.acrcloud.cn/" rel="nofollow" target="_blank" class="link">@音乐识别由 <span>ACRCloud</span> 提供</a>
@endsection
