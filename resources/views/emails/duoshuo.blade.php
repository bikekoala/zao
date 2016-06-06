<p>
    <h3>日志</h3>
    <ul>
        @foreach ($meta as $key => $value)
        <li>{{ $key }}: {{ $value }}</li>
        @endforeach
    </ul>
</p>
<p>
    <b>节目：</b><a href="{{ URL('program') }}/{{ $meta['thread_key'] }}" target="_blank">{{ URL('program') }}/{{ $meta['thread_key'] }}</a>
    <br>
    <b>审核：</b><a href="{{ URL('admin/contributions') }}/{{ $id }}/edit" target="_blank">{{ URL('admin/contributions') }}/{{ $id }}/edit</a>
</p>
