<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
function IncludeRouteGroup($routeFileName){
    include app_path().'/RouteGroup/'.$routeFileName;
}

//注册
IncludeRouteGroup('CommonRoute.php');
//文章处理
IncludeRouteGroup('ArticleRoute.php');
//后台
IncludeRouteGroup('AdminRoute.php');
