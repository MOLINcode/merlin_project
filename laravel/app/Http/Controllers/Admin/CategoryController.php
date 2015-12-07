<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\Tool\Tree;
use App\Services\Tool\ToolKit;
use App\Constants\Category;
use App\Services\Category\CategoryService;
use App\Models\VO\Request\VO_Category;


class CategoryController extends BaseController
{
    /**+'?'+type
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view('admin.category.categoryList');
    }

    //ajax获取列表
    public function ajaxLoadList()
    {
        $tree =  CategoryService::instance()->ajaxCateList();
        return $this->viewAjax('admin.category.ajaxCategoryList')->with(array(
            'listData' => $tree,
        ));
    }

    /**
     * 创建
     * @return mixed
     */
    public function create()
    {

        $obj = new VO_Category;

        if($cate_id = $this->getParam('cate_id')){
            $cateInfo = CategoryService::instance()->getCateInfoById($cate_id);
            if($this->params['type'] == 'create'){
                $obj->pid = $cateInfo->cate_id;
                $obj->cate_name = $cateInfo->cate_name;
                return $this->viewAjax('admin.category.createCategory')->with(
                    array(
                        'cateInfo'  => $obj,
                    )
                );
            }

            return $this->viewAjax('admin.category.createCategory')->with(
                array(
                    'cateInfo' => $cateInfo
                )
            );

        }
        return $this->viewAjax('admin.category.createCategory')->with(
             array(
                'cateInfo'  => $obj,
             )
        );
    }

    public function edit(){

    }
    /**
     * 创建 编辑
     */
    public function store()
    {
        $this->validatorError(Category::$aRole,Category::$aCode);
        if(!CategoryService::instance()->createCategory($this->params)){
            $this->rest->error('创建失败');
        }
        $this->rest->success('','','创建成功');

    }


}
