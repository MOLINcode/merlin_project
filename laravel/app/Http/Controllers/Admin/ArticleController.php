<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-12-8
 * Time: 下午8:18
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use App\Services\Category\CategoryService;
use Request;


class ArticleController extends BaseController
{

    public function index(){
        return $this->view('admin.article.index');
    }


    public function createShow(){
        $allCategory = CategoryService::instance()->getAllCate();
        return $this->view('admin.article.create')->with(
            array(
             'all_cate' =>$allCategory,
            )
        );
    }

    public function store(Request $request){
        dd($request);
    }
}