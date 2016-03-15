@extends('layouts.default')

@section('content')
<article itemtype="http://schema.org/BlogPosting" data-date="{{ $program->dates->id }}">
    <h1 class="post-title" original-title="@if ($contributers['topic'])by <a href='{{ $contributers['topic']['url'] }}' target='_blank'>{{ $contributers['topic']['name'] }}</a>@else @if (empty($program->topic)) 🐶话题 🐶 @endif @endif">@if ($program->topic) {{ $program->topic }} @else 空 @endif</h1>
    <ul class="post-meta" original-title="@if ($contributers['participants'])by <a href='{{ $contributers['participants']['url'] }}' target='_blank'>{{ $contributers['participants']['name'] }}</a>@else @if (empty($program->participants->toArray())) 🐰参与人|参与人 🐰 @endif @endif">
        <li>{{ str_replace('-', '.', $program->date) }}</li>
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
        <video width="85%" height="30" controls="controls" preload="none">
            <source src="{{ $audio->url }}" />
        </video>
        @endforeach
    </div>
    <span class="post-contributers">
        @if ( ! empty($contributers['topic']) or ! empty($contributers['participants']))
            @if ( ! empty($contributers['topic']))
                ( 话题 by <a href="{{ $contributers['topic']['url'] }}" target="_blank">{{ $contributers['topic']['name'] }}</a> )
            @endif
            @if ( ! empty($contributers['participants']))
                ( 参与人 by <a href="{{ $contributers['participants']['url'] }}" target="_blank">{{ $contributers['participants']['name'] }}</a> )
            @endif
        @else
            @if (empty($program->topic) or $program->participants->isEmpty())
                ( 了解参与贡献内容的<a href="http://zaoaoaoaoao.com/about#contribute">方式</a> )
            @endif
        @endif
    </span>
    <ul class="post-near">
        @if ($pages->prev)
        <li class="prev">前一天: <a href="/programs/{{ $pages->prev->dates->id }}">@if ($pages->prev->topic) {{ $pages->prev->topic }} @else 空 @endif</a></li>
        @endif
        @if ($pages->next)
        <li class="next">后一天: <a href="/programs/{{ $pages->next->dates->id }}">@if ($pages->next->topic) {{ $pages->next->topic }} @else 空 @endif</a></li>
        @endif
    </ul>

    <link rel="stylesheet" href="/static/css/player.css" />
    <script src="/static/module/mediaelement/mediaelement-and-player.min.js"></script>
    <script src="/static/module/jquery.cookie.js"></script>
    <script src="/static/js/detail.js"></script>
</article>

@include('layouts.duoshuo')

@endsection
