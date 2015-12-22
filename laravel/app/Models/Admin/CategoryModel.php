<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use App\Models\VO\Request\VO_Category;

class CategoryModel extends BaseModel
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public function mkInfoForInsert(VO_Category $request)
    {
        return array(
            'cate_name' => $request->cate_name,
            'as_name' => $request->cate_name,
            'pid'  => $request->pid,
            'seo_key' => $request->seo_key,
            'seo_title' => $request->seo_title,
            'seo_desc' => $request->seo_desc,
            'created_at' => time(),
            'updated_at' => time(),
        );
    }




}
