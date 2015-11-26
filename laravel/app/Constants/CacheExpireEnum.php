<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-13 下午5:42
 *
 * cache时间 分钟
 */
namespace App\Constants;
class CacheExpireEnum
{
    const EXPIRE_DEFAULT = 5;

    const EXPIRE_DOMAIN_LIST = 1;

    const EXPIRE_USER_INFO = 86400; //24 *3600

    const EXPIRE_ACTIVE_EMAIL = 604800; //7 * 24 * 3600

    //用户中心修改有邮箱过期时间配置
    const USER_CENTER_CHECK_CODE_TIME = 1440; //用户中心修改邮箱,验证码的过期时间1天
    const USER_CENTER_SEND_CODE_TIME = 2;     //用户中心修改邮箱,限制发送发送验证码间隔2分钟
}