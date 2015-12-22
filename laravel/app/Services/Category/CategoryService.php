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
     * 创建分类 or 编辑分类
     * @param $params
     * @return bool
     */

    public function updateCategory($params){
        $oData = $this -> setRequestCategoryParams($params);
        $insetData = $this->mCategory->mkInfoForInsert($oData);
        if(isset($params['cate_id']) && $params['cate_id'] ){
            unset($insetData->created_at);
            if($this->mCategory->baseUpdate($insetData,$params['cate_id'])){
                return false;
            }
        }else{
            if(!$this->mCategory->insert($insetData)){
                return false;
            }
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

    /**
     * 通过id获取分类信息
     * @param $cate_id
     * @return array
     */
    public function getCateInfoById($cate_id){

        $row = $this->mCategory->fetchRow($cate_id);
        return $row;
    }

    /**
     * 获取分类
     * @return array|bool
     */
    public function getAllCate(){
        $catData = array(
            '0' => '顶级分类'
        );
        $data = $this->mCategory->fetchAll();
        $treeData = tree($data);
        dd($treeData);
        foreach ($data as $k => $v) {
            $treeData[$v['cate_id']] = $v['html'] . $v['cate_name'];
        }
        return $catData;
    }






}