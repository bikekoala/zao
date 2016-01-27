@extends('layouts.default')

@section('content')
<div class="archive">
    @foreach ($list as $year => $yearList)
    <h3 class="year">{{ $year }}</h3>
    @foreach ($yearList as $month => $monthList)
    <h3 class="month">{{ $year }} - {{ $month }}</h3>
    <ul>
        @foreach ($monthList as $program)
        <li>
            <a href="/programs/{{ $program->dates->id }}"><span>[{{ $program->dates->day }} . {{ $program->dates->dayNum }}]</span>{{ $program->topic }}</a>
            @if ( ! $program->participants->isEmpty())
            <em>(@foreach ($program->participants as $participant) <a>{{ $participant->name }}</a> @endforeach)</em>
            @endif
        </li>
        @endforeach
    </ul>
    @endforeach
    @endforeach
</div>
@endsection
