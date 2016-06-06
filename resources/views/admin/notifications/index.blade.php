@extends('layouts.admin.default')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">通知消息</div>
        <div class="panel-body">

            @include('layouts.admin.alert')

            <div class="row">
                <div class="col-md-1">
                    <a href="{{ URL('admin/notifications/0/edit') }}" class="btn btn-info">添加</a>
                </div>
            </div>
            <br>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th class="col-md-6">消息</th>
                    <th>过期时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                @foreach ($list as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{!! $item->message !!}</td>
                        <td>{{ $item->duration_at }}</td>
                        @if (1 === $item->state and time() < strtotime($item->duration_at))
                            <td class="text-success">正在进行</td>
                        @elseif (1 === $item->state)
                            <td>已开启</td>
                        @else
                            <td>已关闭</td>
                        @endif
                        <td class="text-muted">
                            <a href="{{ URL('admin/notifications') }}/{{ $item->id }}/edit" role="button" class="btn btn-info btn-xs">编辑</a>
                        </td>
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
