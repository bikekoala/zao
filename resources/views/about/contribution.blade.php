@extends('layouts.default')

@section('content')
<h1 class="post-title">{{ $title }}</h1>
<table class="table-box">
    <tr class="title">
        <th width="100">节目</th>
        <th width="160">作者</th>
        <th>内容</th>
        <th width="140">时间</th>
    </tr>
    @foreach ($comments as $item)
        <tr class="row">
            <td><a href="{{ URL('program') }}/{{ $item->metas->thread_key }}" target="_blank">{{ $item->ext_program_date}}</a></td>
            <td><a href="{{ $item->metas->author_url }}" target="_blank"> {{ $item->metas->author_name }}</a></td>
            <td class="emoji-related">{!! $item->metas->message !!}</td>
            <td>{{ $item->date }}</td>
        </tr>
    @endforeach
</table>

<link rel="stylesheet" href="/static/??css/music.css?v={{ env('STATIC_FILE_VERSION') }}">
@endsection

@section('extra')
<a href="https://github.com/popfeng/zao/blob/master/readme.md" rel="nofollow" target="_blank" class="link">@popfeng</a>
@endsection
