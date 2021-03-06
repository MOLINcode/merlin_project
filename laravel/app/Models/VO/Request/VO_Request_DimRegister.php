<?php
namespace App\Models\VO\Request;
use App\Models\VO\VO_Common;
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-16
 * Time: 下午4:00
 */
class VO_Request_DimRegister extends VO_Common
{
    public $user_id;

    public $user_email;

    public $user_name;

    public $user_pass;

    public $user_status;

    public $user_ticket;

    public $login_time;

    public $last_login_time;

    public $register_time;

    public $relationship_user;

    public $role;

    public $portrait;

    public $credits;

    public $group_id;
}