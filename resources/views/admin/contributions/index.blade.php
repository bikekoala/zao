@extends('layouts.admin.default')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">协同列表</div>
        <div class="panel-body">
            <br>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>节目</th>
                    <th>作者</th>
                    <th>消息</th>
                    <th>审核状态</th>
                </tr>
                @foreach ($list as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><a href="/programs/{{ $item->metas->thread_key }}" target="_blank">{{ $item->ext_program_date}}</a></td>
                        <td><a href="{{ $item->metas->author_url }}" target="_blank"> {{ $item->metas->author_name }}</a></td>
                        <td>{{ $item->metas->message }}</td>
                        @if (-1 === $item->ext_is_agree)
                            <td class="text-warning">未通过</td>
                        @endif
                        @if (0 === $item->ext_is_agree)
                            <td class="text-muted">
                                <a href="/admin/contributions/{{ $item->id }}/edit" role="button" class="btn btn-info btn-xs">审核</a>
                            </td>
                        @endif
                        @if (1 === $item->ext_is_agree)
                            <td class="text-success">已通过</td>
                        @endif
                    </tr>
                @endforeach
            </table>
            <div class="text-center">
                {!! $list->render() !!}
            </div>
        </div>
    </div>
</div>
@endsection
