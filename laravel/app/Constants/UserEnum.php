<?php
/**
 *user常量
 *
 * Class UserEnum
 */
namespace App\Constants;
class UserEnum
{
    /*****用户账号状态*****/
    const REGISTER_STATUS_NORMAL = 1; //可用
    const REGISTER_STATUS_PASS = 2; //不可用
    const REGISTER_STATUS_FAIL = 3; //为激活
    public static function register_status()
    {
         $register_status = array(
            self::REGISTER_STATUS_NORMAL        => '可用',
            self::REGISTER_STATUS_PASS          =>'不可用',
            self::REGISTER_STATUS_FAIL          => '未激活',
        );
        return $register_status;
    }
    public static function getRegisterStatus()
    {
        return self::register_status();
    }

    /*****正式用户状态*****/
    const USER_STATUS_NORMAL = 1; //正常使用
    const USER_STATUS_AWAITING_ACTIVATE = 2; //等待激活
    const USER_STATUS_PAUSED = 3; //已暂停
    const USER_STATUS_DELETED = 4; //已删除
    public static function getUserStatus()
    {
        return array(
            self::USER_STATUS_NORMAL            =>  '正常',
            self::USER_STATUS_AWAITING_ACTIVATE => '待激活',
            self::USER_STATUS_PAUSED            =>  '已暂停',
            self::USER_STATUS_DELETED           =>  '已删除',
        );
    }


    /******* 系统语言 *******/
    const SYSTEM_LANGUAGE_EN = 1; //英文
    const SYSTEM_LANGUAGE_ZN = 2; //中文
    private static $system_language = array(
        self::SYSTEM_LANGUAGE_ZN                => '/resource/img/admin/cn-flag.png',
        self::SYSTEM_LANGUAGE_EN                => '/resource/img/admin/am-flag.png',
    );
    public static function getSystemLanguage()
    {
        return self::$system_language;
    }



    public static function getSystemTimezone()
    {
        return self::system_timezone();
    }

    const TYPE_HTML    = 'html';
    const TYPE_TXT     = 'txt';

    public static function getEmailType()
    {
        return array(
            self::TYPE_HTML => 'HTML',
            self::TYPE_TXT  => 'Txt',
        );
    }

    /********* 用户来源 ********/
    const USER_FROM_TSB = 1; //透视宝注册用户
    const USER_FROM_JKB = 2; //监控宝申请过来的用户

    //用户信息cache标签
    const USER_INFO_CACHE_TAG = '__USER_INFO_TAG';
    //验证码cache标签
    const USER_VERIFICATION_CODE_TAG = '__VERIFICATION_CODE_TAG';
    //用户信息cookie
    const USER_INFO_COOKIE_KEY = '__USER_INFO_TICKET';

    /*****用户角色*****/
    const USER_ROLE_ADMIN    = 1;//管理员
    const USER_ROLE_ADVANCED = 2;//高级用户
    const USER_ROLE_READONLY = 3;//普通用户
    const ADMIN_DES          = 4;//管理员权限描述
    const ADVANCED_DES       = 5;//高级用户权限描述
    const READONLY_DES       = 6;//普通用户权限描述








}
