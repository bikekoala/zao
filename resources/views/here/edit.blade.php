<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">@if (empty($data)) 添加 @else 编辑 @endif</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal" id="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $data->id or '' }}">
        <div class="form-group">
            <label for="date" class="col-sm-2 control-label">时间</label>
            <div class="col-sm-6">
                <div class="input-group date" id="date">
                    <input type='datetime' name="date" class="form-control" value="{{ $data->date or '' }}">
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="location" class="col-sm-2 control-label">地点</label>
            <div class="col-sm-6">
                <select id="location" name="location" style="width: 100%">
                    @if ( ! empty($data))
                    <option value="{{ $data->gm_place_id}}">{{ $data->location }}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <span class="col-md-offset-2 col-sm-6 text-muted" id="message"></span>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default load-remote-modal" data-url="/heres" >返回</button>
    @if ( ! empty($data))
    <button type="button" class="btn btn-warning" id="delete" data-url="/heres">删除</button>
    @endif
    <button type="button" class="btn btn-info" id="submit" data-url="/heres">保存</button>
</div>

<link rel="stylesheet" href="/static/module/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="/static/module/select2/css/select2.min.css">
<link rel="stylesheet" href="/static/module/select2/css/select2-bootstrap.min.css">

<script src="/static/module/moment/min/moment.min.js"></script>
<script src="/static/module/moment/locale/zh-cn.js"></script>
<script src="/static/module/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="/static/module/select2/js/select2.min.js"></script>
<script src="/static/js/here/edit.js"></script>
