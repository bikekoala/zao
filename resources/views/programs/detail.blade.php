@extends('layouts.default')

@section('content')
<article itemtype="http://schema.org/BlogPosting">
    <h1 class="post-title" original-title="@if ($contributers['topic'])<a href='{{ $contributers['topic']['url'] }}' target='_blank'>by {{ $contributers['topic']['name'] }}</a>@else @if (empty($program->topic)) 🐶话题 🐶 @endif @endif">@if ($program->topic) {{ $program->topic }} @else 空 @endif</h1>
    <ul class="post-meta" original-title="@if ($contributers['participants'])<a href='{{ $contributers['participants']['url'] }}' target='_blank'>by {{ $contributers['participants']['name'] }}</a>@else @if (empty($program->participants->toArray())) 🐰参与人|参与人 🐰 @endif @endif">
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
        <li class="prev">前一天: <a href="/programs/{{ $pages->prev->dates->id }}">@if ($pages->prev->topic) {{ $pages->prev->topic }} @else 空 @endif</a></li>
        @endif
        @if ($pages->next)
        <li class="next">后一天: <a href="/programs/{{ $pages->next->dates->id }}">@if ($pages->next->topic) {{ $pages->next->topic }} @else 空 @endif</a></li>
        @endif
    </ul>

    <link rel="stylesheet" href="/static/module/mediaelement/mediaelementplayer.css" />
    <script src="/static/module/mediaelement/mediaelement-and-player.min.js"></script>
    <script type="text/javascript" src="/static/js/detail.js"></script>
</article>

@include('layouts.duoshuo')

@endsection
