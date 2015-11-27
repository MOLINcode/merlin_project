<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-27
 * Time: 上午10:35
 */

namespace App\Models\VO\Request;
use App\Models\VO\VO_Common;

class rVoUserInfo extends  VO_Common
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