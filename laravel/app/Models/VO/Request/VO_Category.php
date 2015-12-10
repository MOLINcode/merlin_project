<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-12-2
 * Time: 下午12:29
 */

namespace App\Models\VO\Request;
use App\Models\VO\VO_Common;

class VO_Category extends VO_Common
{
    public $id;
    public $pid;
    public $cate_name;
    public $as_name;
    public $seo_key;
    public $seo_title;
    public $seo_desc;
    public $created_at;
    public $updated_at;
}