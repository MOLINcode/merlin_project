<?php
/**
 *
 * Class UserService
 */
namespace App\Services\User;
use App\Services\BaseService;
use App\Models\User\UserRegisterModel;
use App\Services\Tool\MailService;
use App\Models\VO\VO_Bound;
use App\Models\VO\Request\VO_Request_DimRegister;
use App\Models\BaseModel;
use App\Services\Tool\CacheService;
use App\Constants\CacheExpireEnum;

class UserService extends BaseService
{
    private static $self = NULL;
    public $mRegister;

    /**
     *
     * @return UserService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    public function __construct(){
        $this->mRegister = new UserRegisterModel();
    }

    /**
     * 生成随机密码
     * @param $length
     * @return string
     */
    public static function makePassword($length)
    {
        $pattern = '1234567890@#$%^&*abcdefghijklmnopqrstuvwxyz'; //字符池,可任意修改
        $key     = '';
        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern{mt_rand(0, strlen($pattern) - 1)}; //生成php随机数
        }

        return $key;
    }

    //创建注册信息
    public function createRegister($params){
        $aData = $this -> mRegister->mkInfoForInsert($params);
        return  $this-> mRegister ->insert($aData);
    }

    /**
     * @var VO_Request_DimRegister
     */
    public $oRegisterUserInfo = NULL;

    public function setRequestRegisterInfoParams($params)
    {
        $this->oRegisterUserInfo = VO_Bound::Bound($params, NEW VO_Request_DimRegister());

        return $this->oRegisterUserInfo;
    }

    /**
     * @return VO_Response_DimRegister
     */
    public function getRegisterInfo()
    {
        $register_id = $this->oRegisterUserInfo->register_id;
        if (!$register_id) return NULL;

        return $this->mRegister->fetchRow($register_id);
    }

    //审核注册
    public function registerCheck($params){
        BaseModel::transStart();
        //创建用户注册表数据
        $oData = $this->setRequestRegisterInfoParams($params);
        if (!$register_id =$this->createRegister($oData)) {
            BaseModel::transRollBack();
            throw new Exception('注册用户失败！');
        }

        $this->setRequestRegisterInfoParams(array('register_id'=>$register_id));
        $registerInfo = $this->getRegisterInfo();


        $user_pass = self::makePassword(6);


        BaseModel::transCommit();
        //发送邮件
        $token = md5(time().$registerInfo->user_email);
        MailService::instance()->sendByMQ('emails.user.user_activate', array(
            'user_name' => $registerInfo->user_name,
            'password'  => $user_pass,
            'token'     => $token,
        ), $registerInfo->user_email, $registerInfo->user_name, 'merlin-feng.com');
        //生成cache
        CacheService::instance()->set($token, $registerInfo->user_email, CacheExpireEnum::EXPIRE_ACTIVE_EMAIL);
        return TRUE;
    }








}