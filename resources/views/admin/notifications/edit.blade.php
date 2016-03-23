@extends('layouts.admin.default')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">编辑消息</div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{ URL('admin/notifications') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_redirect_url" value="{{ URL::previous() }}">
                <input type="hidden" name="id" value="{{ $notification->id or 0}}">
                <div class="form-group">
                    <label for="message" class="col-sm-1 control-label">消息</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="message" name="message" value="{{ $notification->message or '' }}" placeholder="最长18字">
                    </div>
                </div>
                <div class="form-group">
                    <label for="duration" class="col-sm-1 control-label">过期时间</label>
                    <div class="col-sm-5">
                        <div class="input-group date" id="duration">
                            <input type='datetime' name="duration_at" class="form-control" value="{{ $notification->duration_at or '' }}">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-5">
                        <label class="radio-inline">
                            <input type="radio" name="state" @if (isset($notification->state)) @if ($notification->state == 0) checked @endif @else checked @endif value="0"> 关闭
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="state" @if (isset($notification->state) and $notification->state == 1) checked @endif value="1"> 开启
                        </label>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-1">
                        <button type="submit" class="btn btn-info">确定</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="/static/module/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
<script src="/static/module/moment/min/moment.min.js"></script>
<script src="/static/module/moment/locale/zh-cn.js"></script>
<script src="/static/module/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#duration').datetimepicker({
            locale: 'zh-cn',
            format: 'YYYY-MM-DD HH:mm:SS'
        });
    });
</script>
@endsection
