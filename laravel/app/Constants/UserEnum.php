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
    const STATUS_NORMAL = 1; //账号正常
    const STATUS_OFFLINE = 2; //账号过期

    /*****申请用户状态*****/
    const REGISTER_STATUS_NORMAL = 1; //已注册，等待审核
    const REGISTER_STATUS_PASS = 2; //审核通过
    const REGISTER_STATUS_FAIL = 3; //审核失败
    public static function register_status()
    {
         $register_status = array(
            self::REGISTER_STATUS_NORMAL        => Lang::get('system.wait_for_approval'),
            self::REGISTER_STATUS_PASS          => Lang::get('system.approve'),
            self::REGISTER_STATUS_FAIL          => Lang::get('system.unapprove'),
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
            self::USER_STATUS_NORMAL            =>  Lang::get('common.status_normal'),
            self::USER_STATUS_AWAITING_ACTIVATE =>  Lang::get('common.status_awaiting_activate'),
            self::USER_STATUS_PAUSED            =>  Lang::get('common.status_paused'),
            self::USER_STATUS_DELETED           =>  Lang::get('common.status_delete'),
        );
    }
    /******* 手机认证状态 *******/
    const USER_MOBILE_AUTH_YES = 1; //已认证手机
    const USER_MOBILE_AUTH_NO = 2; //未认证手机

    static public $mobile_auth = array(
        self::USER_MOBILE_AUTH_YES              => '解除认证',
        self::USER_MOBILE_AUTH_NO               => '认证手机',
    );

    static public $mobile_is_auth = array(
        self::USER_MOBILE_AUTH_YES              => '已认证',
        self::USER_MOBILE_AUTH_NO               => '未认证',
    );

    static public $mobile_auth_tips = array(
        self::USER_MOBILE_AUTH_NO               => '认证',
        self::USER_MOBILE_AUTH_YES              => '解除绑定',

    );

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

    /******* 系统时区 *******/
    const SYSTEM_TIMEZONE_P0800 = "P0800";
    const SYSTEM_TIMEZONE_N1200 = "N1200";
    const SYSTEM_TIMEZONE_N1100 = "N1100";
    const SYSTEM_TIMEZONE_N1000 = "N1000";
    const SYSTEM_TIMEZONE_N0900 = "N0900";
    const SYSTEM_TIMEZONE_N0800 = "N0800";
    const SYSTEM_TIMEZONE_N0700 = "N0700";
    const SYSTEM_TIMEZONE_N0600 = "N0600";
    const SYSTEM_TIMEZONE_N0500 = "N0500";
    const SYSTEM_TIMEZONE_N0400 = "N0400";
    const SYSTEM_TIMEZONE_N0300 = "N0300";
    const SYSTEM_TIMEZONE_N0200 = "N0200";
    const SYSTEM_TIMEZONE_N0100 = "N0100";
    const SYSTEM_TIMEZONE_P0000 = "P0000";
    const SYSTEM_TIMEZONE_P0100 = "P0100";
    const SYSTEM_TIMEZONE_P0200 = "P0200";
    const SYSTEM_TIMEZONE_P0300 = "P0300";
    const SYSTEM_TIMEZONE_P0400 = "P0400";
    const SYSTEM_TIMEZONE_P0500 = "P0500";
    const SYSTEM_TIMEZONE_P0600 = "P0600";
    const SYSTEM_TIMEZONE_P0630 = "P0630";
    const SYSTEM_TIMEZONE_P0700 = "P0700";
    const SYSTEM_TIMEZONE_P0900 = "P0900";
    const SYSTEM_TIMEZONE_P1000 = "P1000";
    const SYSTEM_TIMEZONE_P1100 = "P1100";
    const SYSTEM_TIMEZONE_P1200 = "P1200";
    const SYSTEM_TIMEZONE_P1300 = "P1300";
    private static function system_timezone()
    {
        $system_timezone = array(
            self::SYSTEM_TIMEZONE_P0800             => Lang::get('system.P0080'),
            self::SYSTEM_TIMEZONE_N1200             => Lang::get('system.N1200'),
            self::SYSTEM_TIMEZONE_N1100             => Lang::get('system.N1100'),
            self::SYSTEM_TIMEZONE_N1000             => Lang::get('system.N1000'),
            self::SYSTEM_TIMEZONE_N0900             => Lang::get('system.N0900'),
            self::SYSTEM_TIMEZONE_N0800             => Lang::get('system.N0800'),
            self::SYSTEM_TIMEZONE_N0700             => Lang::get('system.N0700'),
            self::SYSTEM_TIMEZONE_N0600             => Lang::get('system.N0600'),
            self::SYSTEM_TIMEZONE_N0500             => Lang::get('system.N0500'),
            self::SYSTEM_TIMEZONE_N0400             => Lang::get('system.N0400'),
            self::SYSTEM_TIMEZONE_N0300             => Lang::get('system.N0300'),
            self::SYSTEM_TIMEZONE_N0200             => Lang::get('system.N0200'),
            self::SYSTEM_TIMEZONE_N0100             => Lang::get('system.N0100'),
            self::SYSTEM_TIMEZONE_P0000             => Lang::get('system.P0000'),
            self::SYSTEM_TIMEZONE_P0100             => Lang::get('system.P0100'),
            self::SYSTEM_TIMEZONE_P0200             => Lang::get('system.P0200'),
            self::SYSTEM_TIMEZONE_P0300             => Lang::get('system.P0300'),
            self::SYSTEM_TIMEZONE_P0400             => Lang::get('system.P0400'),
            self::SYSTEM_TIMEZONE_P0500             => Lang::get('system.P0500'),
            self::SYSTEM_TIMEZONE_P0600             => Lang::get('system.P0600'),
            self::SYSTEM_TIMEZONE_P0630             => Lang::get('system.P0630'),
            self::SYSTEM_TIMEZONE_P0700             => Lang::get('system.P0700'),
            self::SYSTEM_TIMEZONE_P0900             => Lang::get('system.P0900'),
            self::SYSTEM_TIMEZONE_P1000             => Lang::get('system.P1000'),
            self::SYSTEM_TIMEZONE_P1100             => Lang::get('system.P1100'),
            self::SYSTEM_TIMEZONE_P1200             => Lang::get('system.P1200'),
            self::SYSTEM_TIMEZONE_P1300             => Lang::get('system.P1300'),
        );
        return $system_timezone;
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
    static public function userRoles()
    {
        $userRoles = array(
        self::USER_ROLE_ADMIN                       => Lang::get('system.admin'),
        self::USER_ROLE_ADVANCED                    => Lang::get('system.advanced_user'),
        self::USER_ROLE_READONLY                    => Lang::get('system.readonly_user'),
        self::ADMIN_DES                             => Lang::get('system.admin_des'),
        self::ADVANCED_DES                          => Lang::get('system.advanced_des'),
        self::READONLY_DES                          => Lang::get('system.readonly_des'),
        );
        return $userRoles;
    }
    public static function getRoles()
    {
        return self::userRoles();
    }
    /*****系统人员状态*****/
    const ADMIN_STATUS_NORMAL = 1; //正常
    const ADMIN_STATUS_PAUSED = 2; //已暂停
    const ADMIN_STATUS_DELETED = 3; //已删除

    /*****系统人员权限*****/
    const ADMIN_RIGHT_MANAGER    = 1;
    const ADMIN_RIGHT_CS_MANAGER = 2;
    const ADMIN_RIGHT_CS_COMMON  = 3;
    const ADMIN_RIGHT_RD_MANAGER = 4;
    const ADMIN_RIGHT_RD_COMMON  = 5;
    const ADMIN_RIGHT_CS_EDITORIAL = 6;

    const ACCOUNT_ID = 1; //测试使用可删除@chencheng
    const USER_ID = 1; //测试使用的可删除@chencheng

    static private function adminRight()
    {
        $adminRight = array(

            self::ADMIN_RIGHT_MANAGER               => '系统管理员',
            self::ADMIN_RIGHT_CS_COMMON             => '客服专员',
            self::ADMIN_RIGHT_CS_MANAGER            => '客服经理',
            self::ADMIN_RIGHT_RD_MANAGER            => '研发经理',
            self::ADMIN_RIGHT_RD_COMMON             => '研发专员',
            self::ADMIN_RIGHT_CS_EDITORIAL          => '编辑专员'
        );
        return $adminRight;
    }
    public static function getAdminRight()
    {
        return self::adminRight();
    }

    /***** 企业行业 *****/
    const COMPANY_INDUSTRY_INTERNET   = 1;
    const COMPANY_INDUSTRY_BUSINESS   = 2;
    const COMPANY_INDUSTRY_GAME       = 3;
    const COMPANY_INDUSTRY_MEDIA      = 4;
    const COMPANY_INDUSTRY_EDUCATION  = 5;
    const COMPANY_INDUSTRY_PRODUCT    = 6;
    const COMPANY_INDUSTRY_GOVERNMENT = 7;
    const COMPANY_INDUSTRY_HOTEL      = 8;
    const COMPANY_INDUSTRY_BIOLOGICAL = 9;
    const COMPANY_INDUSTRY_OTHER      = 10;
    public  static function company_industry()
    {
        $company_industry = array(
            self::COMPANY_INDUSTRY_INTERNET         => Lang::get('system.internet'),
            self::COMPANY_INDUSTRY_BUSINESS         => Lang::get('system.e-business'),
            self::COMPANY_INDUSTRY_GAME             => Lang::get('system.game'),
            self::COMPANY_INDUSTRY_MEDIA            => Lang::get('system.medium'),
            self::COMPANY_INDUSTRY_EDUCATION        => Lang::get('system.education'),
            self::COMPANY_INDUSTRY_PRODUCT          => Lang::get('system.product'),
            self::COMPANY_INDUSTRY_GOVERNMENT       => Lang::get('system.government'),
            self::COMPANY_INDUSTRY_HOTEL            => Lang::get('system.hotel'),
            self::COMPANY_INDUSTRY_BIOLOGICAL       => Lang::get('system.biology'),
            self::COMPANY_INDUSTRY_OTHER            => Lang::get('system.other'),
        );
        return $company_industry;
    }
    public static function getCompanyIndustry()
    {
        return self::company_industry();
    }

    /**
     * @系统设置菜单
     */
    public static $UserSystemMenus  =  array(
        'user_list'    =>  array(
            MenuEnum::LABEL =>  'system.user_management',
            MenuEnum::URL   =>  '/user/user_list',
            MenuEnum::AUTH  =>  AuthEnum::VIEW_SYSTEM
        ),
        /*'pluginManage'    =>  array(
            MenuEnum::LABEL =>  'system.pluginManage',
            MenuEnum::URL   =>  '/user/pluginManage',
            MenuEnum::AUTH  =>  AuthEnum::MODIFY_SYSTEM
        ),*/
    );

}
