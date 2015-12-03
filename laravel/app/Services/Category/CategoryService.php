<?php

/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-12-2
 * Time: 下午12:19
 */
namespace App\Services\Category;
use App\Models\VO\Request\VO_Category;
use App\Services\BaseService;
use App\Services\Tool\Tree;
use App\Models\Admin\CategoryModel;
use App\Models\VO\VO_Bound;

class CategoryService extends BaseService
{
    private static $self = NULL;
    public $mCategory;

    /**
     *
     * @return UserService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    public function __construct(){
        $this ->mCategory = new CategoryModel();
    }

    public $oCategory;
    /**
     * 实例传参
     * @param $params
     * @return \VO_Common
     */
    public function setRequestCategoryParams($params)
    {
        $this->oCategory = VO_Bound::Bound($params, NEW VO_Category());

        return $this->oCategory;
    }

    /**
     * 创建分类
     * @param $params
     * @return bool
     */

    public function createCategory($params){
        $oData = $this -> setRequestCategoryParams($params);
        $insetData = $this->mCategory->mkInfoForInsert($oData);
        if(!$this->mCategory->insert($insetData)){
            return false;
        }
        return true;

    }

    /**
     * ajax列表
     */
    public function ajaxCateList(){
        if(!$data = $this->mCategory->fetchAll()){
            return false;
        }
        $tree = new Tree($data);
        $treeData = $tree->leaf();


        return $treeData;

    }

    public function getCateInfoById($cate_id){
       $row =  $this->mCategory->fetchRow($cate_id);
        return $row;
    }
}