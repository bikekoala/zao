@extends('layouts.default')

@section('content')
<div class="archive">
    @foreach ($list as $year => $yearList)
    <a class="year" id="{{ $year }}" href="#{{ $year }}">{{ $year }}</a>
    @foreach ($yearList as $month => $monthList)
    <a class="month" id="{{ $year }}{{ $month }}" href="#{{ $year }}{{ $month }}">{{ $year }} - {{ $month }}</a>
    <ul>
        @foreach ($monthList as $program)
        <li id="{{ $program->dates->id }}">
            <a href="/programs/{{ $program->dates->id }}"><span>[{{ $program->dates->day }} . {{ $program->dates->dayNum }}]</span>@if ($program->topic) {{ $program->topic }} @else 🐶🐶🐶🐶  @endif</a>
            @if ( ! $program->participants->isEmpty())
            <em>(@foreach ($program->participants as $participant) <a>{{ $participant->name }}</a> @endforeach)</em>
            @else
            <em>( <a>🐰🐰</a>)</em>
            @endif
        </li>
        @endforeach
    </ul>
    @endforeach
    @endforeach
</div>

<div class="tuning">
    <i class="tuning-prev fa fa-angle-up" data-date=""></i>
    <i class="tuning-last fa fa-circle" data-date=""></i>
    <i class="tuning-next fa fa-angle-down" data-date=""></i>
</div>

<script src="/static/module/js-emoji/js/emoji.min.js"></script>
<script src="/static/module/jquery.scrollspy.js"></script>
<script src="/static/module/jquery.cookie.js"></script>
<script src="/static/js/index.js"></script>
@endsection
