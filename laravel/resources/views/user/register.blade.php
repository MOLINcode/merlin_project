<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <title>cloudWind</title>
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
            <img src="{{asset('img/logo.png')}}">
        </a>
    </div>
</div>
<div class="signup">
    <p>{{Lang::get('system.registration')}}</p>
    <form action="/disposeRegister" method="post" id="registerId" class="form-horizontal">
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">{{Lang::get('system.company_name')}}</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="company_name" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">{{Lang::get('system.company_url')}}</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="company_url" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">{{Lang::get('system.contact_person')}}</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="user_name" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">{{Lang::get('system.contact_email')}}</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="user_email" placeholder="">
        </div>
        <a class="col-sm-2 text-left" style="display: none">
            X
        </a>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">{{Lang::get('system.contact_mobile')}}</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="user_mobile" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label"></label>
        <div class="col-sm-7">
            <button class="btn btn-noicon btn-green w100" type="submit">{{Lang::get('system.commit_info')}}</button>
        </div>
    </div>
    </form>
</div>

<script>
    seajs.use('user_register');
</script>
</body>

</html>
