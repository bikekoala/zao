<p>
    <h3>操作信息</h3>
    <ul>
        @foreach ($meta as $key => $value)
        <li>{{ $key }}: {{ $value }}</li>
        @endforeach
    </ul>
</p>
<p>
    <b>节目：</b><a href="https://zaoaoaoaoao.com/programs/{{ $meta['thread_key'] }}" target="_blank">https://zaoaoaoaoao.com/programs/{{ $meta['thread_key'] }}</a>
    <br>
    <b>审核：</b><a href="https://zaoaoaoaoao.com/admin/contributions/{{ $id }}/edit" target="_blank">https://zaoaoaoaoao.com/admin/contributions/{{ $id }}/edit</a>
</p>
