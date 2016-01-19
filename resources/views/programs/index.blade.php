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
            <a href="/programs/{{ $program->date->id }}"><span>[{{ $program->date->day }} . {{ $program->date->day_num }}]</span>{{ $program->topic }}</a>
            <em>(@foreach ($program->participants as $participant) <a>{{ $participant->name }}</a> @endforeach)</em>
        </li>
        @endforeach
    </ul>
    @endforeach
    @endforeach
</div>
@endsection
