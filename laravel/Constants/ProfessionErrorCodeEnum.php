<?php
/**
 * 业务处理错误提示
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-21
 * Time: 下午4:16
 */
//namespace app\Constants;
//use app\Constants\ErrorCodeEnum;
class ProfessionErrorCodeEnum extends ErrorCodeEnum
{
    const ERROR_ACCOUNT_UNAVAILABLE = 1400; //账号不可用
    const ERROR_ACCOUNT_UNACTIVATED = 1401; //账号未激活
    const ERROR_EMAIL_EXISTED = 1402; //email已存在
    const ERROR_EMAIL_FAILURE = 1403; //email不合格
    const ERROR_EMAIL_NULL = 1404; //email为空
    const ERROR_PASSWORD_NULL             = 1405;
    const ERROR_PASSWORD_FAILURE          = 1406;
    const ERROR_PASSWORD_WRONG            = 1407;
    const ERROR_PASSWORD_DIFFERENT        = 1408;
    const ERROR_ACCOUNT_NOT_EXIST         = 1409;
    const ERROR_NO_ACCESS                 = 1410;
    const ERROR_USERNAME_NULL             = 1411;
    const ERROR_USERNAME_FAILURE          = 1412;
    const ERROR_ADMIN_ADD_SUCCESS         = 1413;
    const ERROR_ADMIN_ADD_FAIL            = 1414;
    const ERROR_USER_REGISTER_SUCCESS     = 1415;
    const ERROR_USER_REGISTER_FAIL        = 1416;
    const ERROR_USER_MOBILE_NULL          = 1417;
    const ERROR_USER_MOBILE_FAILURE       = 1418;
    const ERROR_COMPANY_NAME_NULL         = 1419;
    const ERROR_URL_WRONG                 = 1420;
    const ERROR_ACTIVATE_EXPIRED          = 1421;
    const SUCCESS_USER_ACTIVATED          = 1422;
    const ERROR_CREATE_ACCOUNT_FAIL       = 1423;
    const ERROR_CREATE_COMPANY_FAIL       = 1424;
    const ERROR_CREATE_ROLE_FAIL          = 1425;
    const ERROR_CREATE_GROUP_FAIL         = 1426;
    const ERROR_VERIFICATION_CODE_NULL    = 1427;
    const ERROR_VERIFICATION_CODE_WRONG   = 1428;
    const ERROR_VERIFICATION_CODE_EXPIRED = 1429;
    const ERROR_VERIFICATION_CODE_EXIST   = 1430;
    const ERROR_SYSTEM_TIMEZONE_WRONG     = 1431;
    const ERROR_SYSTEM_LANGUAGE_WRONG     = 1432;
    const ERROR_EMAIL_TYPE_WRONG          = 1433;
    const ERROR_PASSWORD_OLD_NEW_REPEAT   = 1434;
    const ERROR_MODIFY_USERINFO_REPEAT    = 1435;
    const ERROR_MODIFY_COMPANYINFO_REPEAT = 1436;

    const ERROR_JKB_INVALID   = 1437;
    const ERROR_JKB_NO_AUTH   = 1438;
    const ERROR_PHONE_EXISTED = 1439; //phone已存在
    const ERROR_COMPANY_URL_NULL    = 1440;
    const ERROR_APPNAME_NOT_UPDATED = 1441;


    private static $error_message = array(
        self::ERROR_ACCOUNT_UNAVAILABLE       => '账号被暂停或已禁用',
        self::ERROR_ACCOUNT_UNACTIVATED       => '账号未激活',
        self::SUCCESS_USER_ACTIVATED          => '账号已激活',
        self::ERROR_EMAIL_EXISTED             => '该邮箱地址已经存在',
        self::ERROR_EMAIL_FAILURE             => '错误的邮箱地址',
        self::ERROR_PHONE_EXISTED             => '该手机号已经存在',
        self::ERROR_EMAIL_NULL                => '邮箱地址不能为空',
        self::ERROR_PASSWORD_NULL             => '密码不能为空',
        self::ERROR_PASSWORD_FAILURE          => '密码必须为大于6位的数字或字符',
        self::ERROR_PASSWORD_WRONG            => '原始密码错误，请核对后再输入',
        self::ERROR_PASSWORD_DIFFERENT        => '两次输入的密码不同',
        self::ERROR_ACCOUNT_NOT_EXIST         => '不存在的用户',
        self::ERROR_NO_ACCESS                 => '没有访问权限',
        self::ERROR_USERNAME_NULL             => '用户名不能为空',
        self::ERROR_USERNAME_FAILURE          => '用户名不符合规则',
        self::ERROR_ADMIN_ADD_SUCCESS         => '添加管理员成功',
        self::ERROR_ADMIN_ADD_FAIL            => '添加管理员失败',
        self::ERROR_USER_REGISTER_SUCCESS     => '申请成功，请耐心等待客服审核',
        self::ERROR_USER_REGISTER_FAIL        => '对不起，申请失败,请稍后重新申请',
        self::ERROR_USER_MOBILE_NULL          => '手机号码为空',
        self::ERROR_USER_MOBILE_FAILURE       => '错误的手机号码',
        self::ERROR_COMPANY_NAME_NULL         => '公司名称不能为空',
        self::ERROR_URL_WRONG                 => '链接地址错误',
        self::ERROR_ACTIVATE_EXPIRED          => '激活邀请已过期',
        self::ERROR_CREATE_ACCOUNT_FAIL       => '创建账号失败',
        self::ERROR_CREATE_COMPANY_FAIL       => '添加公司信息失败',
        self::ERROR_CREATE_ROLE_FAIL          => '创建角色失败',
        self::ERROR_CREATE_GROUP_FAIL         => '创建分组失败',

        self::ERROR_VERIFICATION_CODE_NULL    => '验证码为空',
        self::ERROR_VERIFICATION_CODE_WRONG   => '验证码错误',
        self::ERROR_VERIFICATION_CODE_EXPIRED => '验证码已过期',
        self::ERROR_VERIFICATION_CODE_EXIST   => '验证码已经发送，请注意查收',
        self::ERROR_SYSTEM_TIMEZONE_WRONG     => '错误的系统时区',
        self::ERROR_SYSTEM_LANGUAGE_WRONG     => '错误的系统语言',
        self::ERROR_EMAIL_TYPE_WRONG          => '错误的email格式',
        self::ERROR_PASSWORD_OLD_NEW_REPEAT   => '新旧密码重复',
        self::ERROR_MODIFY_USERINFO_REPEAT    => '个人信息没有变更，无须修改',
        self::ERROR_MODIFY_COMPANYINFO_REPEAT => '组织信息没有变更，无须修改',

        self::ERROR_JKB_INVALID               => '用户名或密码不合法',
        self::ERROR_JKB_NO_AUTH               => '您没有权限试用透视宝',
        self::ERROR_COMPANY_URL_NULL          => '网站链接不能为空',
        self::ERROR_APPNAME_NOT_UPDATED       => '该应用名称没有修改'
    );


    public static function getErrorMessage()
    {
//        return self::$error_message;
        return Lang::get('constants.professionErrorCodeEnum');
    }
}