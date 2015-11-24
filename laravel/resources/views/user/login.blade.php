<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<div class="signin text-center">
    <img src="{{asset('/img/logo_lg.png')}}">
    <form method="post" id="__login_form" class="form-horizontal">
    <div class="form-group">
        <label for="" class="col-sm-3 control-label">{{Lang::get('system.account')}}：</label>
        <div class="col-sm-7">
            <input type="email" class="form-control sign" placeholder="Email" name="user_email">
        </div>
    </div>
    <div class="form-group ">
        <label for="" class="col-sm-3 control-label">{{Lang::get('system.pass')}}：</label>
        <div class="col-sm-7">
            <input type="password" class="form-control sign" placeholder="Password" name="user_pass">
        </div>
        <a class="col-sm-2 text-left" style="display: none">
            X
        </a>
    </div>
    <div class="form-group signin-set">
        <label for="" class="col-sm-3 control-label"></label>
        <div class="col-sm-7 clearfix">
            <div class="50% fl checkbox">
                <label>
                    <input type="checkbox" name="remember" value="1"> {{Lang::get('system.keep_load')}}
                </label>
            </div>
            <div class="50% fr">
                <a href="/register">{{Lang::get('system.registration')}}</a>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-3 control-label"></label>
        <div class="col-sm-7">
            <button class="btn btn-noicon btn-green w100 load" id="submit" type="button" >{{Lang::get('system.load')}}
            </button>
        </div>
    </div>
   </form>
</div>




<script type="text/javascript" src="{{asset('/js/common/sea/sea.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/common/sea/config.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/common/jquery/jquery.min.js')}}"></script>

<script language="javascript">
    seajs.use('user_signin');
</script>
</body>

</html>
