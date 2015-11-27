<?php
/**
 *
 * Class UserService
 */
namespace App\Services\User;
use App\Constants\UserEnum;
use App\Services\BaseService;
use App\Models\User\UserRegisterModel;
use App\Models\User\UserInfoModel;
use App\Services\Tool\MailService;
use App\Models\VO\VO_Bound;
use App\Models\VO\Request\rVoUserInfo;
use App\Models\BaseModel;
use App\Services\Tool\CacheService;
use App\Constants\CacheExpireEnum;

class UserService extends BaseService
{
    private static $self = NULL;
    public $mUserInfo;

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
        $this ->mUserInfo = new UserInfoModel();
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

    /**
     * @param $params
     * @return int
     */
    public function createUserInfo($params){
        $aData = $this -> mUserInfo->mkInfoForInsert($params);
        return  $this-> mUserInfo ->insert($aData);
    }

    /**
     * @var rVoUserInfo
     */
    public $oUserInfo = NULL;

    public function setRequestUserInfoParams($params)
    {
        $this->oUserInfo = VO_Bound::Bound($params, NEW rVoUserInfo());

        return $this->oUserInfo;
    }

    /**
     * @return VO_Response_DimRegister
     */
    public function getUserInfoById($uerId = null)
    {
        $user_id = $this->oUserInfo->user_id?$this->oUserInfo->user_id:$uerId;
        if (!$user_id) return NULL;

        return $this->mUserInfo->fetchRow($user_id);
    }

    /**
     * @param  $user_email
     * @return bool
     * @throws Exception
     */
    public function getUserInfoByEmail($user_email){
        if (!$user_email) return NULL;

        return $this->mUserInfo->fetchRow(array('user_email'=>$user_email));
    }

    /**
     * @param $user_id
     */
    public function updateUserStatusForActivate($user_id){
        $arr = array(
            'user_status' => UserEnum::REGISTER_STATUS_NORMAL,
        );
        $this->mUserInfo->update($arr,$user_id);
    }

    /**
     * @param $params
     * @return bool
     * @throws Exception
     */
    public function registerCheck($params){
        BaseModel::transStart();
        //创建用户注册表数据
        $oData = $this->setRequestUserInfoParams($params);
        //随机密码
        $user_pass = self::makePassword(6);
        $oData->user_pass = $user_pass;

        if (!$user_id =$this->createUserInfo($oData)) {
            BaseModel::transRollBack();
            throw new Exception('注册用户失败！');
        }

        $this->setRequestUserInfoParams(array('user_id'=>$user_id));
        $registerInfo = $this->getUserInfoById();
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

       //用户表生成
        return TRUE;
    }

    /**
     * @param $user_id
     * @return bool
     */
    public function createUserInfoCache($oUserInfo){
        $token = md5($oUserInfo->user_id);
        $sUserInfo = json_encode($oUserInfo);
        CacheService::instance()->set($token, $sUserInfo, CacheExpireEnum::EXPIRE_ACTIVE_EMAIL);
        return true;
    }

    public function getUserInfoCache($user_id){
        $key = md5($user_id);
        if(CacheService::instance()->exists($key)){
            $jUserInfo = json_decode(CacheService::instance()->get($key));
            return $jUserInfo;
        }

        return $this->getUserInfoById($user_id);
    }








}