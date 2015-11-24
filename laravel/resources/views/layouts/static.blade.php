<?php
use app\ViewSpall\ResourceSpall;
$version = ResourceSpall::getResourceVersion();
?>
@section('common_meta')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="云智慧,云智慧APM,APM,应用性能管理,企业云服务,SaaS云服务"/>
<meta name="description" content="云智慧是国内领先的应用性能管理（Application Performance Management）服务商。旗下产品-监控宝和透视宝已为几十万企业级用户提供了前瞻性的智慧型性能管理服务"/>
@stop

@section('common_css')

<link rel="icon" href="/favicon.ico">
<?php
ResourceSpall::includeCSS('commonCSS');
?>

@stop

@section('common_js_header')

<?php ResourceSpall::includeJS('commonHeadJS');?>
<!--[if lt IE 9]>
<script type="text/javascript" src="/resource/js/common/html5shiv.min.js"></script>
<script type="text/javascript" src="/resource/js/common/respond.min.js"></script>
<![endif]-->

<!--[if lt IE 8]>
<script type="text/javascript">
    window.onload = function () {
        document.getElementsByTagName('body')[0].innerHTML = '<div class="alert alert-danger">您的浏览器版本太低了，赶紧升级吧，亲！！！！</div>';
    }
</script>
<![endif]-->
@stop

@section('common_js_footer')
<?php ResourceSpall::includeJS('commonFooterJS');?>
@stop


@section('common_js_config')
<script>
    var APPCONFIG = <?php echo isset($json_config) ? json_encode($json_config) : json_encode(array());?>;
</script>
@stop

@section('ajax_js_config')
<?php
if (isset($ajax_config))
{
    echo '<script>var AJAXCONFIG = '. (is_array($ajax_config) ? json_encode($ajax_config) : json_encode(array()) ).'</script>';
}
?>
@stop
