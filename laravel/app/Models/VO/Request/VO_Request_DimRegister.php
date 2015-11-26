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
    public $register_id = null;

    public $user_email;

    public $user_name;

    public $register_time;

    public $register_status;

    public $relationship_user;

}