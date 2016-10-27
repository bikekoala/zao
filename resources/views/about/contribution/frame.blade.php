@extends('layouts.default')

@section('content')
{!! $archive !!}

<link rel="stylesheet" href="/static/??css/music.css?v={{ env('STATIC_FILE_VERSION') }}">
@endsection

@section('extra')
<a href="https://github.com/popfeng/zao/blob/master/readme.md" rel="nofollow" target="_blank" class="link">@popfeng</a>
@endsection
