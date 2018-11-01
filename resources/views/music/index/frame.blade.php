@extends('layouts.default')

@section('content')

{!! $archive !!}

<!--div class="ds-thread" data-thread-key="music" data-title="飞鱼秀の大歌单" data-url="{{ URL('music') }}"></div-->
@include('layouts.disqus')

<link rel="stylesheet" href="/static/css/music.css">
<script src="/static/js/music/index.js"></script>
@endsection
