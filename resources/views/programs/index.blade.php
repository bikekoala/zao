@extends('layouts.default')

@section('content')
<div class="archive">
    @foreach ($list as $year => $yearList)
    <a class="year" id="{{ $year }}" href="#{{ $year }}">{{ $year }}</a>
    @foreach ($yearList as $month => $monthList)
    <a class="month" id="{{ $year }}{{ $month }}" href="#{{ $year }}{{ $month }}">{{ $year }} - {{ $month }}</a>
    <ul>
        @foreach ($monthList as $program)
        <li>
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
@endsection
