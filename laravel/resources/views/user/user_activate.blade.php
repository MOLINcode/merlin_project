<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="云智慧,云智慧APM,APM,应用性能管理,企业云服务,SaaS云服务" />
    <meta name="description" content="云智慧是国内领先的应用性能管理（Application Performance Management）服务商。旗下产品-监控宝和透视宝已为几十万企业级用户提供了前瞻性的智慧型性能管理服务" />
    <title>@if($activated) 激活成功 @else 激活失败 @endif -压测宝</title>
    <link rel="icon" href="/favicon.ico">
    <!-- Bootstrap Style -->
    <link rel="stylesheet" href="{{asset('/css/common/bootstrap/bootstrap.min.css')}}">
    <!-- font-awesome Style -->
    <link rel="stylesheet" href="{{asset('/css/common/font-awesome.min.css')}}">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{asset('/css/common/main.css')}}">
    <link rel="stylesheet" href="{{asset('/css/signIn/signin-up.css')}}">
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{asset('/js/signIn/html5shiv/html5shiv.min.js')}}"></script>
    <![endif]-->
    <!--[if lt IE 8]>
    <script type="text/javascript">
        window.onload = function () {
            document.getElementsByTagName('body')[0].innerHTML = '<div class="alert alert-danger">您的浏览器版本太低了，赶紧升级吧，亲！！！！</div>';
        }
    </script>
    <![endif]-->
    <script src="{{asset('/js/common/jquery/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/common/bootstrap/bootstrap.min.js')}}" type="text/javascript "></script>
</head>

<body>

    <div class="navbar navbar-fixed-top web-navbar-top">
        <div class="navbar-header">
            <a href="/" class="navbar-brand">
                <img src="{{asset('/img/logo.png')}}"></a>
        </div>
    </div>
    @if($activated == true)
    <!--激活成功 -->
    <div class="signup sure">
        <img src="{{asset('img/common/smile.png')}}">
        <p class="succ">{{Lang::get('system.active_success')}}</p>
        <p>{{Lang::get('system.your_email')}}&nbsp;&nbsp;<span class="text-bold">{{$email}}</span>&nbsp;&nbsp;{{Lang::get('system.done')}}</p><br>
        {{Lang::get('system.suggest_info')}}
        <p class="time"><span id="num">3</span> {{Lang::get('system.count_down')}}...</p>
        <button class="btn btn-noicon btn-green">{{Lang::get('system.sure')}}</button>
    </div>
    <script language="javascript" type="text/javascript">
        $(function(){
            var i = 5;
            var intervalid = setInterval(function(){
                if (i == 0) {
                    window.location.href = "/";
                    clearInterval(intervalid);
                }
                $('#num').html(i);
                i--;
            }, 1000);
        });
    </script>
    @else
    <!--激活失败-->
    <div class="signup sure">
        <img src="/resource/img/common/sad.png">
        <p class="succ">{{Lang::get('system.active_failed')}}</p>
        <p class="p" style="color: #ff3e3e"> {{$tips}}</p>
        <br><br>
        <p class="p" style="text-align:center">
            {{Lang::get('system.help_info')}}
            <br>
            {{Lang::get('system.hot_line')}}：010-88579792
            <br>
            {{Lang::get('system.qq_group')}}：113881151
        </p>
        <div class="user-check-fail-button">
            <a href="/" class="btn btn-noicon btn-green">{{Lang::get('system.back_index')}}</a>
        </div>
    </div>
    @endif

</body>

</html>
