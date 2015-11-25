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
        UserService::instance()->sendMail($this->params['user_email']);
        $this->validatorError($aRole, $aCode);
        $this->rest->success('','','Success');
    }

    //注册成功
    public function registerSuccess(){
        $email = 'http://mail.'.explode('@',$this->getParam('mail'))[1];
        return  view('user.registerSuccess',array(
            'email'=>$email,
        ));
    }


    //登录页
    public function loginIndex()
    {
        return view('user.login');
    }

}
