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
Route::get('/', function () {
    return view('welcome');
});

//注册
IncludeRouteGroup('CommonRoute.php');
