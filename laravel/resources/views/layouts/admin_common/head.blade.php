@section('admin_head')
<div class="navbar navbar-inverse navbar-fixed-top web-navbar-top">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#web-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="/" class="navbar-brand"><img src="/resource/img/logo.png">
        </a>
    </div>
    <div id="web-navbar-collapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
            <li>
                <!-- 变动html以及class -->
                <div class="createNewProjectTarget" tabindex='-1'>
                    <div class="establish" data-url="/app/create">
                        <a href="/app/create">
                            <span class="establish_app"></span>
                            <div class="establish_text">应用</div>
                        </a>
                    </div>

                    <div class="establish" data-url="/mobile/sdk/app_create">
                        <a href="/mobile/sdk/app_create">
                            <span class="establish_mobile"></span>
                            <div class="establish_text">移动</div>
                        </a>
                    </div>

                </div>
                <!-- 变动html以及class -->
            </li>
            <li>
                <a class="navbar-userpic" data-toggle="modal" data-target="#userCenter" href="/user/center">
                    <img src="/resource/img/avatar/025.jpg" alt=""/>
                    <span class="navbar-username">{{ $info->admin_name }}</span>
                </a>
            </li>
            <li>
                <a href="/login_out" title="退出系统" onclick="Javascript:return confirm('确实要退出系统吗？')"><img src="/resource/img/icon/exit.png" alt="exit"></a>
            </li>
        </ul>
    </div>
</div>

@stop


