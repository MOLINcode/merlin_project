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
     * 创建或者编辑modal
     * @return mixed
     */
    public function create()
    {
        $obj = new VO_Category;
        $type = $this->getParam('type');
        switch ($type)
        {
            case 'zCreate':
                $obj->pid = 0;
                return $this->viewAjax('admin.category.createCategory')->with(
                        array(
                                'cateInfo'  => $obj,
                                'p_name'  => '顶级分类',
                        )
                );
                break;
            case 'create':
                $pid = $this->params['cate_id'];
                $cateInfo = CategoryService::instance()->getCateInfoById($pid);
                $obj->pid = $pid;
                return $this->viewAjax('admin.category.createCategory')->with(
                        array(
                                'p_name'  => $cateInfo->cate_name,
                                'cateInfo'  => $obj,
                        )
                );
                break;
            case 'edit':

                dd(CategoryService::instance()->getAllCate());
                $cate_id = $this->getParam('cate_id');
                $cateInfo = CategoryService::instance()->getCateInfoById($cate_id);
                $p_name = '顶级分类';
                if($cateInfo->pid){
                    $oData = CategoryService::instance()->getCateInfoById($cateInfo->pid);
                    $p_name = $oData->cate_name;
                }

                return $this->viewAjax('admin.category.createCategory')->with(
                        array(
                                'cateInfo'  => $cateInfo,
                                'p_name' =>$p_name,

                        )
                );
                break;
        }
    }


    /**
     * 创建 编辑 执行
     */
    public function store()
    {
        $this->validatorError(Category::$aRole,Category::$aCode);
        if(!CategoryService::instance()->updateCategory($this->params)){
            $this->rest->error('操作失败');
        }
        $this->rest->success('','','操作成功');

    }


}
