<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">打卡列表</h4>
</div>
<div class="modal-body">
    <table class="table table-condensed table-hover">
        <thead>
            <tr>
                <th class="col-sm-2">时间</th>
                <th class="col-sm-4">地点</th>
                <th class="col-sm-1">编辑</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($list as $item)
            <tr>
                <td>{{ $item->date }}</td>
                <td><a href="{{ $item->gm_url }}" target="_blank">{!! $item->location !!}</a></td>
                <td>
                    <button type="button" class="btn btn-default btn-xs load-remote-modal" data-url="/heres/{{ $item->id }}/edit" title="编辑"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>&nbsp;
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    <button type="button" class="btn btn-info load-remote-modal" data-url="/heres/create">添加</button>
</div>
