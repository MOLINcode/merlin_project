<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-30
 * Time: 下午5:47
 */

Route::group(array('prefix' => '/admin'),function () {
    Route::get('/category', 'Admin\CateGoryController@index');
});