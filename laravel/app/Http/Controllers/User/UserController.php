<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use App\Services\User\UserService;
use App\Constants\ProfessionErrorCodeEnum;

class UserController extends BaseController
{
    //注册页
    public function registerIndex()
    {
       return view('user.register');
    }

    //处理注册
    public function disposeRegister(){

        $aRole = array(
            'user_name'  => 'required',
            'user_email' => 'required|email',
        );
        $aCode = array(
            "user_name" =>array(
                ProfessionErrorCodeEnum::ERROR_USER_NAME_NULL
            ),
            "user_email"=>array(
                ProfessionErrorCodeEnum::ERROR_USER_EMAIL_NULL,
                ProfessionErrorCodeEnum::ERROR_EMAIL_FAILURE,
                ),
        );
        $this->validatorError($aRole, $aCode);
        $this->rest->success('注册成功');
    }

    //登录页
    public function loginIndex()
    {
        return view('user.login');
    }

}
