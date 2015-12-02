<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-12-2
 * Time: 上午11:04
 */

namespace App\Constants;


class Category
{
    public static $aRole = array(
        'cate_name'  => 'required',
        'as_name' => 'required',
    );
    public static $aCode = array(
        'cate_name' =>array(
            self::CATEGORY_NAME_NULL
        ),
        'as_name' =>array(
            self::CATEGORY_AS_NAME_NULL
        ),
    );


    const CATEGORY_NAME_NULL = 800;
    const CATEGORY_AS_NAME_NULL = 801;

    private static $error_message = array(
      self::CATEGORY_NAME_NULL => '分类名称不能为空',
      self::CATEGORY_AS_NAME_NULL => '分类别名称不能为空',
    );

    public static function getErrorMessage()
    {
        return self::$error_message;
    }

}