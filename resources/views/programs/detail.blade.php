@extends('layouts.default')

@section('content')
<article itemtype="http://schema.org/BlogPosting">
    <h1 class="post-title">{{ $program->topic }}</h1>
    <ul class="post-meta">
        <li>{{ $program->dates->year }}.{{ $program->dates->month }}.{{ $program->dates->day }}</li>
        <li>周{{ $program->dates->dayNum}}</li>
        <li>
            @foreach ($program->participants as $participant)
            <a>{{ $participant->name }}</a>
            @endforeach
        </li>
    </ul>
    <div class="post-content">
        @foreach ($audios as $audio)
        <p>{{ $audio->title }}</p>
        <video width="80%" height="30" controls="controls" preload="none">
            <source src="{{ $audio->url }}" />
        </video>
        @endforeach
    </div>
    <ul class="post-near">
        @if ($pages->prev)
        <li class="prev">前一天: <a href="/programs/{{ $pages->prev->dates->id }}">{{ $pages->prev->topic }}</a></li>
        @endif
        @if ($pages->next)
        <li class="next">后一天: <a href="/programs/{{ $pages->next->dates->id }}">{{ $pages->next->topic }}</a></li>
        @endif
    </ul>

    <link rel="stylesheet" href="/static/module/mediaelement/mediaelementplayer.css" />
    <script src="/static/module/mediaelement/mediaelement-and-player.min.js"></script>
    <script type="text/javascript" src="/static/js/audio.js"></script>
</article>
@endsection

@section('comment')
<link rel="stylesheet" href="/static/css/duoshuo.css" />
<script type="text/javascript" src="/static/js/duoshuo.js"></script>
<div class="ds-thread" data-thread-key="107dc65b4c78ff09c7c8a7e336f5d8b4" data-title="{{ $program->date }} - {{ $program->topic }}" data-url="{{ Config::get('app.url') }}/programs/{{ $program->dates->id}}"></div>
@endsection
