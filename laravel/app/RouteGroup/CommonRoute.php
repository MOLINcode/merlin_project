<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-24
 * Time: 上午10:07
 */

//注册
Route::get('/register','User\UserController@registerIndex');
Route::post('/disposeRegister','User\UserController@disposeRegister');
Route::get('/registerSuccess','User\UserController@registerSuccess');

//用户激活UserActivate
Route::get('/user_activate','User\UserController@userActivate');

//登录
Route::get('/login','User\UserController@loginIndex');
Route::post('/disposeLogin','User\UserController@disposeLogin');