<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-24
 * Time: 上午10:07
 */
Route::get('/register','User\UserController@registerIndex');
Route::post('/disposeRegister','User\UserController@disposeRegister');
Route::get('/registerSuccess','User\UserController@registerSuccess');
Route::get('/login','User\UserController@loginIndex');