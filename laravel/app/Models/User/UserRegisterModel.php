<?php

namespace App\Models\User;
use App\Models\BaseModel;
use App\Models\VO\Request\VO_Request_DimRegister;
use App\Constants\UserEnum;

class UserRegisterModel extends BaseModel
{
    protected $table = 'user_register';
    protected $primaryKey = 'register_id';

    public function mkInfoForInsert(VO_Request_DimRegister $request)
    {
        return array(
            'user_email'       => $request->user_email,
            'user_name'        => $request->user_name,
            'register_time'    => time(),
            'register_status'  => UserEnum::REGISTER_STATUS_PASS,
            'relationship_user' => $request->relationship_user,
        );
    }
}
