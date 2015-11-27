<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use App\Services\User\UserService;
use App\Constants\ProfessionErrorCodeEnum;
use App\Constants\UserEnum;
use App\Services\Tool\CacheService;
use App\Models\BaseModel;

class UserController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerIndex()
    {
       return view('user.register');
    }

    /**
     * @throws \App\Services\User\Exception
     */
    public function disposeRegister()
    {
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
        //审核
        UserService::instance()->registerCheck($this->params);
        $this->rest->success('','','Success');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerSuccess()
    {
        $email = 'http://mail.'.explode('@',$this->getParam('mail'))[1];
        return  view('user.registerSuccess',array(
            'email'=>$email,
        ));
    }


    /**
     * 激活用户
     * @return mixed
     */
    public function userActivate()
    {
        $token   = $this->params['token'];
        $err_msg = ProfessionErrorCodeEnum::getErrorMessage();

        if (!$token) {
            $tips = $err_msg[ProfessionErrorCodeEnum::ERROR_URL_WRONG];
            return self::showTemplate($tips);
        }

        if (!CacheService::instance()->exists($token)) {
            $tips = $err_msg[ProfessionErrorCodeEnum::ERROR_ACTIVATE_EXPIRED];
            return self::showTemplate($tips);
        }

//        激活
        //验证用户
        $user_email = CacheService::instance()->get($token);
        $oUserInfo  = UserService::instance()->getUserInfoByEmail($user_email);
        if (!$oUserInfo) {
            $tips = $err_msg[ProfessionErrorCodeEnum::ERROR_ACCOUNT_NOT_EXIST];
            return self::showTemplate($tips, $user_email);
        }

        try {
            BaseModel::transStart();
            if($oUserInfo->user_status == UserEnum::REGISTER_STATUS_FAIL)
                if (!UserService::instance()->updateUserStatusForActivate($oUserInfo->user_id)) {
                    throw(new Exception('激活失败'));
                }
            $tips = '激活成功';
            BaseModel::transCommit();

            CacheService::instance()->del($token);
            $activated = TRUE;

        } catch (Exception $e) {
            BaseModel::transRollBack();
            $activated = FALSE;
            $tips      = '激活失败';
        }

        return view('user.user_activate')->with(array(
            'tips'      => $tips,
            'activated' => $activated,
            'email'     => $user_email
        ));
    }

    /**
     * 展示用户激活页面
     * @param        $tips
     * @param string $email
     * @param bool $activated
     * @return mixed
     */
    public function showTemplate($tips, $email = '', $activated = FALSE)
    {
        return view('user.user_activate')->with(array(
            'tips'      => $tips,
            'activated' => $activated,
            'email'     => $email
        ));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginIndex()
    {
        return view('user.login');
    }

    //处理登录
    public function disposeLogin()
    {
        $aRole = array(
            'user_email' => 'required|email',
            'user_pass'  => 'required',
        );
        $aCode = array(
            "user_email"=>array(
                ProfessionErrorCodeEnum::ERROR_USER_EMAIL_NULL,
                ProfessionErrorCodeEnum::ERROR_EMAIL_FAILURE,
            ),
            "user_pass" => array(
                ProfessionErrorCodeEnum::ERROR_PASSWORD_NULL
            )
        );
        $this->validatorError($aRole,$aCode);
        $user_email = $this->params['user_email'];
        if(!$oUserInfo = UserService::instance()->getUserInfoByEmail($user_email))
        {
            $this->rest->error('该用户不存在');
        }

        if($this->params['user_pass'] != $oUserInfo->user_pass)
        {
            $this->rest->error('用户密码错误');
        }
        //建立cache
        if(! UserService::instance()->createUserInfoCache($oUserInfo)){

        }

        $this->rest->success();
    }

}
