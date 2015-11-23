@section('front_header')
<!-- header start -->
<div class="navbar navbar-fixed-top web-navbar-top">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#web-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="/" class="navbar-brand">
            <img src="/resource/img/common/logo.png"></a>
    </div>
    <div id="web-navbar-collapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a class="pdtop-20" href="#" target="_blank">
                    <img src="/resource/img/common/help.png" alt="压测宝帮助中心"></a>
            </li>
            <li>
                <a href="/user/center" data-toggle="modal" data-target="#user_center">
                    <span class="navbar-username">{{ UserService::getUserCache()->user_name }}</span>
                    <img src="/resource/img/common/user_head.png" alt="">
                </a>
            </li>
            <li>
                <a href="/signin_out" title="退出系统" onclick="javascript:return confirm('{{Lang::get('common.quit_alert')}}')"><img src="/resource/img/exit.png" alt="exit"></a>
            </li>
        </ul>
    </div>
</div>
{{--//用户中心--}}
<div id="user_center" class="modal"></div>
@stop