@extends('layouts.default')

@section('content')
<h1 class="post-title">{{ $title }}</h1>
<table class="table-box">
    <tr class="title">
        <th>昵称</th>
        <th>邮箱/网址/电话</th>
        <th>留言</th>
        <th>金额（元）</th>
        <th>日期</th>
    </tr>
    @foreach ($list as $item)
    <tr class="row">
        <td>{{ $item->name ?: '--' }}</td>
        <td>{{ $item->profile ?: '--' }}</td>
        <td>{{ $item->message}}</td>
        <td>{{ $item->amount}}</td>
        <td>{{ $item->date }}</td>
    </tr>
    @endforeach
</table>
@endsection
