<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-30
 * Time: 下午5:47
 */
use App\Constants\UserMenuEnum;
Route::group(array('prefix' => '/admin'),function () {

    /**
     * 分类
     */
    Route::group(array('group'=>UserMenuEnum::GROUP_CATEGORY), function() {
        //分类列表
        Route::get('/category', 'Admin\CategoryController@index');
        //创建分类modal
        Route::post('/category/create', 'Admin\CategoryController@create');
        //ajax分类列表
        Route::post('/ajaxCategoryList', 'Admin\CategoryController@ajaxLoadList');
        //编辑分类modal
        Route::post('/editCategory/{cate_id}', 'Admin\CategoryController@create');
        //添加分类 更改 dispose
        Route::post('/addCategory', 'Admin\CategoryController@store');
        //删除分类
        Route::post('/delCategory/{cate_id}', 'Admin\CategoryController@delete');
    });


    /**
     * 文章
     */
    Route::group(array('group'=>UserMenuEnum::GROUP_ARTICLE), function() {
        //首页
        Route::get('/article', 'Admin\ArticleController@index');
        //创建页
        Route::get('/article/create', 'Admin\ArticleController@createShow');

        //执行创建
        Route::post('/article/store/{article_id?}','Admin\ArticleController@store');
    });


});