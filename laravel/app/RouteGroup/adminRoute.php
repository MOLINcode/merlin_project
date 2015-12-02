<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-30
 * Time: 下午5:47
 */

Route::group(array('prefix' => '/admin'),function () {
    //分类列表
    Route::get('/category', 'Admin\CategoryController@index');
    //创建分类
    Route::get('/category/create','Admin\CategoryController@create');
    //ajax分类列表
    Route::post('/ajaxCategoryList','Admin\CategoryController@ajaxLoadList');
    //添加分类
    Route::post('/addCategory','Admin\CategoryController@store');
});