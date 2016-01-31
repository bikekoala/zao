@extends('layouts.admin.default')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading"><b>审核协同请求</b></div>
        <div class="panel-body">
            <form class="form-horizontal" action="/admin/{{ $module }}/{{ $log->id }}/edit" method="POST">
                <input name="_method" type="hidden" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_redirect_url" value="/admin/{{ $module }}">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">日志</label>
                    <div class="col-sm-8">
                        <table class="table table-bordered ">
                            @foreach ($log->metas as $key => $value)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{!! nl2br($value) !!}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">当前话题</label>
                    <div class="col-sm-8">
                        <p class="form-control-static">
                            <a href="/programs/{{ $program->dates->id }}" target="_blank">@if ($program->topic) {{ $program->topic}} @else 空 @endif</a>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">当前参与人</label>
                    <div class="col-sm-8">
                        <p class="form-control-static">
                            @if ( ! $program->participants->isEmpty())
                                {{ implode('，', array_column($program->participants, 'name')) }}
                            @else
                                空
                            @endif
                        </p>
                    </div>
                </div>
                @if ( ! empty($signs['TOPIC']))
                <div class="form-group">
                    <label class="col-sm-2 control-label">协同话题</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="topic" value="{{ $signs['TOPIC'] }}" placeholder="话题名称">
                    </div>
                </div>
                @endif
                @if ( ! empty($signs['PARTICIPANT']))
                <div class="form-group">
                    <label class="col-sm-2 control-label">协同参与人</label>
                    <div class="col-sm-8" data-toggle="tooltip" data-placement="right" title="分隔符：| ">
                        <input type="text" class="form-control" name="participants" value="{{ implode('|', $signs['PARTICIPANT']) }}" placeholder="参与人名单">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-8">
                        <p class="form-control-static">
                            Tips: {{ implode('，', array_column($participants->toArray(), 'name')) }}
                        </p>
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <label class="col-sm-2 control-label">操作</label>
                    <div class="col-sm-8">
                        <label class="radio-inline">
                            <input type="radio" name="state" value="1" checked> 通过
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="state" value="0"> 拒绝
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="reply-message" value="" placeholder="想回复的话">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-3">
                        <button type="submit" class="btn btn-info">确认</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="/static/js/tooltip.js"></script>
<script type="text/javascript" src="/static/js/admin/contributions-edit.js"></script>

@endsection
