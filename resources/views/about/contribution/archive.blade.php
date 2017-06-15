<h1 class="post-title">{{ $title }}</h1>
<table class="post-contribution table-box">
    <tr class="title">
        <th>节目</th>
        <th>作者</th>
        <th>内容</th>
        <th>时间</th>
    </tr>
    @foreach ($comments as $item)
    <tr class="row">
        <td><a href="{{ $item->cmt_url }}" target="_blank">{{ $item->program_date}}</a></td>
        <td><a href="{{ $item->author_url }}" target="_blank"> {{ $item->author_name }}</a></td>
        <td class="emoji-related">{!! trim($item->message) !!}</td>
        <td>{{ $item->cmt_created_at }}</td>
    </tr>
    @endforeach
</table>
