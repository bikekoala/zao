@extends('layouts.default')

@section('content')
<h1 class="post-title">{{ $title }}</h1>
<table class="table-box">
    <tr class="title">
        <th>昵称</th>
        <th>邮箱/网址</th>
        <th>来源</th>
        <th>金额（元）</th>
        <th>日期</th>
    </tr>
    <tr class="row">
        <td>晓雯</td>
        <td>lul***&lt;at&gt;hotmail.com</td>
        <td>alipay</td>
        <td>50</td>
        <td>2016-10-04</td>
    </tr>
    <tr class="row">
        <td>--</td>
        <td>--</td>
        <td>wechat</td>
        <td>8.88</td>
        <td>2016-09-22</td>
    </tr>
    <tr class="row">
        <td>--</td>
        <td>--</td>
        <td>wechat</td>
        <td>50</td>
        <td>2016-08-27</td>
    </tr>
    <tr class="row">
        <td>贝壳</td>
        <td>--</td>
        <td>wechat</td>
        <td>18</td>
        <td>2016-07-21</td>
    </tr>
    <tr class="row">
        <td>媛</td>
        <td><a href="http://weibo.com/sophiemilu" rel="nofollow" target="_blank">http://weibo.com/sophiemilu</a></td>
        <td>alipay</td>
        <td>10</td>
        <td>2016-05-03</td>
    </tr>
    <tr class="row">
        <td>夹心糖</td>
        <td>jfz***&lt;at&gt;vip.sina.com</td>
        <td>alipay</td>
        <td>100</td>
        <td>2016-04-30</td>
    </tr>
    <tr class="row">
        <td>dongqingxia</td>
        <td>--</td>
        <td>wechat</td>
        <td>100</td>
        <td>2016-04-23</td>
    </tr>
    <tr class="row">
        <td>Vincent</td>
        <td>vincentme&lt;at&gt;gmail.com</td>
        <td>wechat</td>
        <td>10</td>
        <td>2016-04-05</td>
    </tr>
    <tr class="row">
        <td>Siru</td>
        <td>siru.zhou&lt;at&gt;gmail.com</td>
        <td>wechat</td>
        <td>50</td>
        <td>2016-03-28</td>
    </tr>
</table>
@endsection

@section('extra')
<a href="https://github.com/popfeng/zao/blob/master/readme.md" rel="nofollow" target="_blank" class="link">@popfeng</a>
@endsection
