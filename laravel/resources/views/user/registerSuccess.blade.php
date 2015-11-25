<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="云智慧,云智慧APM,APM,应用性能管理,企业云服务,SaaS云服务" />
    <meta name="description" content="云智慧是国内领先的应用性能管理（Application Performance Management）服务商。旗下产品-监控宝和透视宝已为几十万企业级用户提供了前瞻性的智慧型性能管理服务" />
    <title>云智慧_新一代应用性能管理（APM）领导者 世界级企业云服务商</title>
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
</head>

<body>

    <div class="navbar navbar-fixed-top web-navbar-top">
        <div class="navbar-header">
            <a href="/" class="navbar-brand">
                <img src="{{asset('/img/logo.png')}}"></a>
        </div>
    </div>
    <div class="signup sure">
        <img src="{{asset('/img/common/smile.png')}}">
        <p class="succ">{{Lang::get('system.congratulation_info')}}</p>
        <p>{{Lang::get('system.tips1')}}<br>{{Lang::get('system.tips2')}}</p>
        <a class="btn btn-noicon btn-green" href="{{$email}}" target="_blank">{{Lang::get('system.tips3')}}</a>
    </div>

</body>

</html>
