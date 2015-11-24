<?php
/**
 * 业务处理错误提示
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-21
 * Time: 下午4:16
 */
namespace App\Constants;
use App\Constants\ErrorCodeEnum;
class ProfessionErrorCodeEnum extends  ErrorCodeEnum
{
    const ERROR_ACCOUNT_UNAVAILABLE = 1400; //账号不可用
    const ERROR_ACCOUNT_UNACTIVATED = 1401; //账号未激活
    const ERROR_EMAIL_EXISTED = 1402; //email已存在
    const ERROR_EMAIL_FAILURE = 1403; //email不合格
    const ERROR_USER_NAME_NULL = 1404;
    const ERROR_USER_EMAIL_NULL = 1405;



    private static $error_message = array(
        self::ERROR_ACCOUNT_UNAVAILABLE       => '账号被暂停或已禁用',
        self::ERROR_ACCOUNT_UNACTIVATED       => '账号未激活',
        self::ERROR_EMAIL_EXISTED             => '该邮箱地址已经存在',
        self::ERROR_EMAIL_FAILURE             => '错误的邮箱地址',
        self::ERROR_USER_EMAIL_NULL           => '邮箱地址为空',
        self::ERROR_USER_NAME_NULL            => '用户名称为空',

    );


    public static function getErrorMessage()
    {
        return self::$error_message;
//        return Lang::get('constants.professionErrorCodeEnum');
    }
}