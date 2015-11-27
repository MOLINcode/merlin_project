<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-27
 * Time: 上午10:31
 */

namespace App\Models\User;
use App\Models\BaseModel;
use App\Models\VO\Request\rVoUserInfo;
use App\Constants\UserEnum;


class UserInfoModel extends BaseModel
{
    protected $table = 'user_info';
    protected $primaryKey = 'user_id';

    public function mkInfoForInsert(rVoUserInfo $request)
    {
        return array(
            'user_email'       => $request->user_email,
            'user_name'        => $request->user_name,
            'register_time'    => time(),
            'user_status'  => UserEnum::REGISTER_STATUS_FAIL,
            'relationship_user' => $request->relationship_user,
        );
    }
}