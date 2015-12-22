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
    //创建分类modal
    Route::post('/category/create','Admin\CategoryController@create');
    //ajax分类列表
    Route::post('/ajaxCategoryList','Admin\CategoryController@ajaxLoadList');
    //编辑分类modal
    Route::post('/editCategory/{cate_id}','Admin\CategoryController@create');
    //添加分类 更改 dispose
    Route::post('/addCategory','Admin\CategoryController@store');
    //删除分类
    Route::post('/delCategory/{cate_id}','Admin\CategoryController@delete');

});