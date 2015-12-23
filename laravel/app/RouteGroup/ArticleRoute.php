<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-30
 * Time: 下午12:28
 */

//首页
Route::get('/','ArticleController@index');

//文章
Route::group(array('prefix' => '/article'),function () {



});