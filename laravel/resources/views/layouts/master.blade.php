<?php
$version = App\ViewSpall\ResourceSpall::getResourceVersion();
?>
@section('common_meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
@endsection

@section('common_css')

    <link rel="icon" href="{{asset('/favicon.ico')}}">
    <?php App\ViewSpall\ResourceSpall::includeCSS('commonCSS');?>

@endsection

@section('common_js_header')

<?php App\ViewSpall\ResourceSpall::includeJS('commonHeadJS');?>
<!--[if lt IE 9]>
    <script type="text/javascript" src="{{asset('/js/common/html5shiv.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/common/respond.min.js')}}"></script>
    <![endif]-->

    <!--[if lt IE 8]>
    <script type="text/javascript">
        window.onload = function () {
            document.getElementsByTagName('body')[0].innerHTML = '<div class="alert alert-danger">您的浏览器版本太低了，赶紧升级吧，亲！！！！</div>';
        }
    </script>
    <![endif]-->
@endsection

@section('common_js_footer')
    <?php App\ViewSpall\ResourceSpall::includeJS('commonFooterJS');?>
@endsection


@section('common_js_config')
    <script>
        var APPCONFIG = <?php echo isset($json_config) ? json_encode($json_config) : json_encode(array());?>;
    </script>
    @endsection

    @section('ajax_js_config')
    <?php
    if (isset($ajax_config))
    {
        echo '<script>var AJAXCONFIG = '. (is_array($ajax_config) ? json_encode($ajax_config) : json_encode(array()) ).'</script>';
    }
    ?>
@endsection
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
                <img src="{{asset('/img/common/logo.png')}}">
            </a>
        </div>
        <div id="web-navbar-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a class="pdtop-20" href="#" target="_blank">
                        <img src="{{asset('/img/common/help.png')}}" alt="帮助中心"></a>
                </li>
                <li>
                    <a href="/user/center" data-toggle="modal" data-target="#user_center">
                        <span class="navbar-username">merlin</span>
                        <img src="{{asset('/img/common/user_head.png')}}" alt="">
                    </a>
                </li>
                <li>
                    <a href="/signin_out" title="退出系统" onclick="javascript:return confirm('{{Lang::get('common.quit_alert')}}')"><img src="{{asset('/img/exit.png')}}" alt="exit"></a>
                </li>
            </ul>
        </div>
    </div>
    {{--//用户中心--}}
    <div id="user_center" class="modal"></div>
@endsection

<html>
<head>
    <title>@yield('title')</title>
    @yield('common_meta')
    @yield('common_css')
    @yield('app_css')
    @yield('common_js_header')
</head>
<body>
@yield('common_js_config')
@yield('front_header')

{{--@yield('front_left')--}}
@yield('content')
@yield('common_js_footer')
@yield('app_js')
</body>
</html>