@extends('layouts.default')

@section('content')
<div class="archive">
    {!! $archive !!}
</div>

<div class="tuning">
    <i class="tuning-prev fa fa-angle-up" data-date=""></i>
    <i class="tuning-last fa fa-circle" data-date=""></i>
    <i class="tuning-next fa fa-angle-down" data-date=""></i>
</div>

<script src="/static/??module/jquery/jquery.scrollspy.js,js/index.js"></script>
@endsection

@section('footer_extra')
<br>
<a href="http://www.beian.miit.gov.cn" rel="nofollow" target="_blank" class="link">京ICP备16005034号</a>
@endsection
