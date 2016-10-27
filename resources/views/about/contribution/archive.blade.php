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
        <td><a href="{{ URL('program') }}/{{ $item->metas->thread_key }}" target="_blank">{{ $item->ext_program_date}}</a></td>
        <td><a href="{{ $item->metas->author_url }}" target="_blank"> {{ $item->metas->author_name }}</a></td>
        <td class="emoji-related">{!! $item->metas->message !!}</td>
        <td>{{ $item->date }}</td>
    </tr>
    @endforeach
</table>
