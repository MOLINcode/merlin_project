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
    <?php
        App\ViewSpall\ResourceSpall::includeCSS('commonCSS');
        App\ViewSpall\ResourceSpall::includeCSS('article');
    ?>

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
    <header>
        <h1>如影随形</h1>
        <h2>影子是一个会撒谎的精灵，它在虚空中流浪和等待被发现之间;在存在与不存在之间....</h2>
        <div class="logo"><a href="http://www.jsdaima.com/"></a></div>
        <nav id="topnav">
            <a href="index.html">首页</a>
            <a href="about.html">关于我</a>
            <a href="/article/indexInfo">慢生活</a>
            <a href="share.html">模板分享</a>
            <a href="new.html">模板主题</a>
        </nav>
    </header>
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
<div class="ibody">
@yield('front_header')
@yield('front_left')
@yield('content')
</div>
@yield('common_js_footer')
@yield('app_js')
</body>
</html>