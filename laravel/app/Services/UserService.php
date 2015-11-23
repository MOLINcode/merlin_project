<?php
/**
 *
 * Class UserService
 */
class UserService extends BaseService
{
    private static $self = NULL;

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

    /**
     * @var VO_Request_DimUser
     */
    private $oUserInfo = NULL;

    /**
     * @var VO_Request_DimSubUser
     */
    private $oSubUserInfo = NULL;

    /**
     * @var null|User_UserAccountModel
     */
    private $mUserAccountModel = NULL;

    /**
     * @var null|User_UserInfoModel
     */
    private $mUserInfoModel = NULL;
    /**
     * @var null|User_UserPersonalSettingModel
     */
    private $mPersonalSettingModel = NULL;

    /**
     * @var VO_Response_UserCache
     */
    private static $getUserCache = NULL;

    public function __construct()
    {
        $this->mPersonalSettingModel = new User_UserPersonalSettingModel();
        $this->mUserInfoModel        = new User_UserInfoModel();
        $this->mUserAccountModel     = new User_UserAccountModel();
    }

    /**
     * @param $params
     * @return VO_Request_DimUser
     */
    public function setRequestUserInfoParams($params)
    {
        $this->oUserInfo = VO_Bound::Bound($params, NEW VO_Request_DimUser());
        return $this->oUserInfo;
    }

    /**
     * @param $params
     * @return VO_Request_DimSubUser
     */
    public function setRequestSubUserParams($params)
    {
        $this->oSubUserInfo = VO_Bound::Bound($params, NEW VO_Request_DimSubUser());
        return $this->oSubUserInfo;
    }


    /**
     * @return VO_Response_UserCache
     */
    public static function getUserCache()
    {
        if (is_null(self::$getUserCache)) {
            if (Cookie::has(CacheKeyEnum::USER_INFO_COOKIE_KEY)) {
                $ticket             = Cookie::get(CacheKeyEnum::USER_INFO_COOKIE_KEY);
                self::$getUserCache = CacheService::instance()->get($ticket, CacheKeyEnum::USER_INFO_CACHE_TAG);
            }
        }

        return self::$getUserCache;
    }

    /*
     * 根据用户id修改用户信息
     *
     */
    public function modifyUserRole($account_id, $user_id, $role_right)
    {
        $userRoleModel = new User_UserRoleModel();

        $roleInfo = $userRoleModel->getAccountRoles($account_id, $role_right);

        $info = array(
            'role_id' => $roleInfo->role_id
        );
        $userRoleModel->setTableToJoinTable();
        return $userRoleModel->update($info, array('user_id' => $user_id));

    }


    /**
     * 同时在本地和cwop中创建用户
     * @return bool|int|null
     * @throws Exception
     */
    /* public function createUser()
     {
         $user_email = $this->oUserInfo->user_email;

         if (self::checkExits($user_email)) {
             $code = ProfessionErrorCodeEnum::ERROR_EMAIL_EXISTED;
             $msg  = ProfessionErrorCodeEnum::getErrorMessage();
             throw new Exception($msg[$code], $code);
         }

         $this->mUserInfoModel = new User_UserInfoModel();
         $aData                = $this->mUserInfoModel->mkUserParamsForInsert($this->oUserInfo);
         if ($this->checkExits()) return NULL;
         if (!$user_id = $this->mUserInfoModel->insert($aData)) return FALSE;

         //创建个人设置
         UserPersonalSettingService::instance()->setRequestParams(array('user_id' => $user_id));

         if (!UserPersonalSettingService::instance()->createUserPersonalSet()) {
             return FALSE;
         }

         return $user_id;
     }*/

    /**
     * 更新user_info中的cwop_accessToken
     * @param $cwopUserId
     * @param $cwopAccountId
     * @param $cwopAccessToken
     * @return int
     */
    public function updateUserInfoCwopAccessToken($cwopUserId, $cwopAccountId, $cwopAccessToken)
    {
        $this->mUserInfoModel = new User_UserInfoModel();
        $aWhere               = array(
            'relationship_cwop_user_id'    => $cwopUserId,
            'relationship_cwop_account_id' => $cwopAccountId,
        );
        $this->mUserInfoModel->setSelect(array('relationship_cwop_accessToken'));
        if (!$userInfo = $this->mUserInfoModel->fetchRow($aWhere)) {
            return false;
        }

        if ($userInfo->relationship_cwop_accessToken != $cwopAccessToken) {
            if (!$this->mUserInfoModel->update(array('relationship_cwop_accessToken' => $cwopAccessToken), $aWhere)) {
                return false;
            }
        }

        return true;
    }

    /**
     * 创建账户
     * @return int
     */
    public function createAccount()
    {
        $aData = $this->mUserAccountModel->mkAccountParamsFoInsert($this->oUserInfo);

        return $this->mUserAccountModel->insert($aData);
    }

    /**
     * 检查email是否存在
     *
     * @param null $email
     * @return bool
     */
    public function checkExits($email = NULL)
    {
        if (is_null($email))
            $email = $this->oUserInfo->user_email;

        $where = array('user_email' => $email, 'user_status in ?' => (array(UserEnum::USER_STATUS_NORMAL, UserEnum::USER_STATUS_AWAITING_ACTIVATE, UserEnum::USER_STATUS_PAUSED, UserEnum::USER_STATUS_DELETED)));
        return $this->mUserInfoModel->exists($where);
    }

    /**
     * 验证是否是本应用的账户
     * @param null $cwop_id
     * @internal param null $email
     * @return bool
     */
    public function checkExitsByCwopId($cwop_id = NULL)
    {
        if (is_null($cwop_id)) {
            $cwop_id = $this->oUserInfo->relationship_cwop_user_id;
        }

        $where = array('relationship_cwop_user_id' => $cwop_id, 'user_status in ?' => (array(UserEnum::USER_STATUS_NORMAL, UserEnum::USER_STATUS_AWAITING_ACTIVATE, UserEnum::USER_STATUS_PAUSED, UserEnum::USER_STATUS_DELETED)));
        return $this->mUserInfoModel->exists($where);
    }

    /**
     * @param null $email
     * @return VO_Response_DimUser
     */
    public function getUserInfoByEmail($email = NULL)
    {
        if (is_null($email)) {
            if (is_null($this->oUserInfo))
                return FALSE;
            $email = $this->oUserInfo->user_email;
        }

        $where = array('user_email = ?' => $email);

        return $this->mUserInfoModel->fetchRow($where);
    }

    /**
     * @param $cwop_id
     * @internal param null $email
     * @return VO_Response_DimUser
     */
    public function getUserInfoByCwopId($cwop_id)
    {
        $where = array('relationship_cwop_user_id = ?' => $cwop_id);

        return $this->mUserInfoModel->fetchRow($where);
    }

    /**
     * @param null $mobile
     * @return VO_Response_DimUser
     */
    public function getUserInfoByMobile($mobile = NULL)
    {
        if (is_null($mobile)) {
            $mobile = $this->oUserInfo->user_email;
        }

        $where = array(
            'user_mobile = ?' => $mobile,
            'mobile_auth = ?' => UserEnum::USER_MOBILE_AUTH_YES,
        );

        return $this->mUserInfoModel->fetchRow($where);
    }

    public function getPersonalSetting($user_id = NULL)
    {
        if (is_null($user_id))
            $user_id = $this->oUserInfo->user_id;
        $where = array('user_id = ?' => $user_id);

        return $this->mPersonalSettingModel->fetchRow($where);
    }

    /**
     * 用户激活时，将account与用户绑定
     * @param $user_id
     * @param $account_id
     * @return bool
     */
    public function relationshipAccount($user_id, $account_id)
    {
        if (!$user_id || !$account_id)
            return FALSE;
        self::getUserInfo();
        if (!$this->mUserInfoModel->exists($user_id))
            return FALSE;
        if (!$this->mUserAccountModel->exists($account_id))
            return FALSE;
        $aUpdate = array('account_id' => $account_id);

        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }


    public function getAccountId()
    {
        $user_id = $this->oUserInfo->user_id;
        if (!$user_id)
            return NULL;

        $this->mUserInfoModel->setSelect(array('account_id'));
        $result = $this->mUserInfoModel->fetchRow($user_id);

        return $result->account_id;
    }

    /**
     * @param null $user_id
     * @return VO_Response_DimUser
     */
    public function getUserInfo($user_id = NULL)
    {
        if (is_null($user_id))
            $user_id = $this->oUserInfo->user_id;
        if (!$user_id)
            return NULL;

        return $this->mUserInfoModel->fetchRow($user_id);
    }


    /**
     * 获取account_info信息
     *
     * @param null $account_id
     * @return VO_Response_DimUser
     */
    public function getUserAccount($account_id = NULL)
    {
        if (is_null($account_id))
            $account_id = $this->oUserInfo->account_id;
        if (!$account_id)
            return NULL;

        return $this->mUserAccountModel->fetchRow($account_id);
    }

    /**
     *
     * 根据user_id获取用户的所有信息
     *
     * @param null $user_id
     * 即user_info信息和account_info信息
     * @return VO_Response_DimUser
     */
    public function getUserInfoAll($user_id = NULL)
    {
        if (is_null($user_id))
            $user_id = $this->oUserInfo->user_id;
        if (!$user_id)
            return NULL;

        return $this->mUserInfoModel->getUserInfoAll($user_id);
    }

    /**
     * 批量更新account状态
     *
     * @param array $account_ids
     * @param       $iStatus
     * @return bool
     */
    public function upAccountStatusByIds(array $account_ids, $iStatus = UserEnum::STATUS_NORMAL)
    {
        if (count($account_ids) < 1)
            return FALSE;

        $aWhere = array(
            'account_id in ?' => $account_ids,
        );

        $aUpdate = array(
            'account_status' => $iStatus,
        );

        return $this->mUserAccountModel->update($aUpdate, $aWhere);
    }

    /**
     * 获取账户的余额
     */
    public function getAccountBalance($account_id)
    {
        $this->mUserAccountModel->setSelect(array('balance_value'));

        return $this->mUserAccountModel->fetchRow(array('account_id = ?' => $account_id));
    }

    /**
     * 更新账户余额
     */
    public function updateAccountBalance($account_id, $money)
    {
        $aUpdate = array('balance_value' => $money);
        $aWhere  = array(array('account_id = ?' => $account_id));
        if (-1 == $this->mUserAccountModel->update($aUpdate, $aWhere))
            return FALSE;

        return TRUE;
    }

    /**
     * 更新套餐
     * @param $package_id
     * @param $account_id
     * @return bool
     */
    public function updateAccountPackage($package_id, $account_id)
    {
        if (!$account_id || !$package_id)
            return FALSE;
        $aUpdate = array('package_id' => $package_id);

        return $this->mUserAccountModel->update($aUpdate, $account_id);
    }

    /**
     * 根据ticket获取user_id
     *
     * @param $ticket
     * @return null
     */
    public function getUserIdByTicket($ticket)
    {
        if (!$ticket)
            return NULL;
        $aWhere = array('user_ticket = ?' => $ticket);
        $this->mUserInfoModel->setSelect(array('user_id'));
        $oInfo = $this->mUserInfoModel->fetchRow($aWhere);
        $this->mUserInfoModel->removeSelect();
        if (!$oInfo)
            return NULL;

        return $oInfo->user_id;
    }

    /**
     * 修改用户登录时间
     * @param $user_id
     * @return bool
     */
    public function updateUserLoginTime($user_id)
    {
        if (!$user_id)
            return FALSE;
        $login_time      = time();
        $oUserInfo       = self::getUserInfo($user_id);
        $last_login_time = $oUserInfo->login_time;
        if (empty($oUserInfo->login_time)) {
            $last_login_time = $login_time;
        }
        $aUpdate = array('login_time' => $login_time, 'last_login_time' => $last_login_time);

        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    /**
     * 设置用户信息cache
     *
     * @param      $ticket
     * @param null $access_token
     * @return bool
     */
    public function setUserCache($ticket = NULL, $access_token = NULL)
    {
        if (is_null($ticket))
            $ticket = Cookie::get(CacheKeyEnum::USER_INFO_COOKIE_KEY);
        if (is_null($access_token))
            $access_token = UserService::instance()->getUserCache()->access_token;
        if (!$ticket)
            return FALSE;
        $user_id = self::getUserIdByTicket($ticket);
        if (!$user_id)
            return FALSE;
        $oUserInfo = self::getUserInfoAll($user_id);
        $oRoleInfo = RoleService::instance()->getUserRole($user_id);
        $oPersonal = UserPersonalSettingService::instance()->getUserPersonalSetting($user_id);
        $params    = array();
        foreach ($oUserInfo as $key => $value) {
            $params[$key] = $value;
        }

        foreach ($oRoleInfo as $key => $value) {
            $params[$key] = $value;
        }
        foreach ($oPersonal as $key => $value) {
            $params[$key] = $value;
        }
        $cacheUserInfo               = VO_Bound::Bound($params, NEW VO_Request_UserCache());
        $cacheUserInfo->access_token = $access_token;
        CacheService::instance()->set($ticket, $cacheUserInfo, CacheExpireEnum::EXPIRE_USER_INFO, CacheKeyEnum::USER_INFO_CACHE_TAG);

        return TRUE;
    }

    public function login($uid, $access_token, $remember = NULL)
    {
        $oUserInfo = UserService::instance()->getUserInfoAll($uid);
        if (UserService::instance()->setUserCache($oUserInfo->user_ticket, $access_token)) {
            //修改登录时间
            UserService::instance()->updateUserLoginTime($oUserInfo->user_id);
            //生成cookie
            if (isset($remember) && $remember == 1) {
                $cookie = Cookie::forever(CacheKeyEnum::USER_INFO_COOKIE_KEY, $oUserInfo->user_ticket);
            } else {
                $cookie = Cookie::make(CacheKeyEnum::USER_INFO_COOKIE_KEY, $oUserInfo->user_ticket, CacheExpireEnum::EXPIRE_USER_INFO);
            }
            return $cookie;
        }
    }

    /**
     * 检查cwop返回的当前用户,是否存在tsb中
     * @param $relationship_cwop_account_id
     * @param $relationship_cwop_user_id
     *
     * @return bool|PrimaryKeyValue
     */
    public function exitsAccountIdCwopByAccountAndUser($relationship_cwop_account_id, $relationship_cwop_user_id)
    {
        $where = array('relationship_cwop_account_id' => $relationship_cwop_account_id, 'relationship_cwop_user_id' => $relationship_cwop_user_id);

        $userInfo = $this->mUserInfoModel->fetchRow($where);
        if (!$userInfo)
            return FALSE;

        return $userInfo->account_id;
    }

    /**
     * cwop 中存在的用户，tsb中不存在的主账户，完成注册，审核，激活，流程
     */
    public function processLogin($ret, $aGetInfoData)
    {
        $login_user_id    = FALSE;
        $login_account_id = FALSE;

        $is_master = array_key_exists('is_master', $aGetInfoData) ? $aGetInfoData['is_master'] == 1 : 0;

        if (array_key_exists('master', $ret['data'])) {
            $masterData = $ret['data']['master'];

            $tsbAccountId = UserService::instance()->exitsAccountIdCwopByAccountAndUser($masterData['account_id'], $masterData['user_id']);
            if (!$tsbAccountId) {
                // 创建注册信息
                $masterData['company_name']     = $masterData['company'];
                $masterData['company_industry'] = UserEnum::COMPANY_INDUSTRY_INTERNET;
                $masterData['company_url']      = '';

                UserRegisterService::instance()->setRequestRegisterInfoParams($masterData);
                if (!$reg_id = UserRegisterService::instance()->createRegister()) {
                    $this->professionError(ProfessionErrorCodeEnum::ERROR_USER_REGISTER_FAIL);
                }

                $createInfo       = self::processCreateMasterUser($reg_id, $masterData['user_id'], $masterData['account_id']);
                $login_account_id = $createInfo['account_id'];
                $login_user_id    = $createInfo['user_id'];
            } else {
                $login_account_id = $tsbAccountId;
            }

            if (!$is_master) {
                if (array_key_exists('users', $ret['data'])) {
                    $users = $ret['data']['users'];

                    $userRoleModel = new User_UserRoleModel();

                    $roleInfo = $userRoleModel->getAccountRoles($login_account_id, UserEnum::USER_ROLE_ADVANCED);

                    if (!$roleInfo) {
                        throw new Exception(Lang::get('system.failed_get_role'));
                    }

                    $role_id = $roleInfo->role_id;
                    if (!$role_id) {
                        throw new Exception(Lang::get('system.failed_get_role'));
                    }

                    $group_id = GroupService::instance()->getAccountRootGroupId($login_account_id);
                    if (!$group_id) {
                        throw new Exception(Lang::get('system.failed_get_group'));
                    }

                    foreach ($users as $user) {
                        $params['group_id']        = $group_id;
                        $params['role_id']         = $role_id;
                        $params['user_name']       = $user['user_name'];
                        $params['user_email']      = $user['user_email'];
                        $params['app_account_id']  = $login_account_id;
                        $params['user_pass']       = UserRegisterService::instance()->makePassword(6);
                        $params['activating_time'] = time();
                        $params['user_status']     = UserEnum::USER_STATUS_NORMAL;
                        $params['cwop_user_id']    = $user['user_id'];
                        $params['cwop_account_id'] = $user['account_id'];
                        $params['channel']         = PartnerEnum::CLOUDWISE;

                        $subUserInfo = self::setRequestSubUserParams($params);

                        if (!$user_id = self::processCreateSubUser($subUserInfo)) {
                            throw new Exception(Lang::get('system.failed_create_group'));
                        }
                        //直接激活
                        UserService::instance()->updateUserStatusForActivate($user_id);

                        $login_user_id = $user_id;
                    }
                }
            }
        }

        return $login_user_id;
    }


    /**
     * 创建主用户（管理员）
     * @param $reg_id  user_register表中的register_id
     * @param $cwop_user_id
     * @param $cwop_account_id
     * @return array|bool|null
     * @throws Exception
     */
    public function processCreateMasterUser($reg_id, $cwop_user_id, $cwop_account_id,$accessToken)
    {
        UserRegisterService::instance()->setRequestRegisterInfoParams(array('register_id' => $reg_id, 'register_status' => UserEnum::REGISTER_STATUS_PASS));
        UserRegisterService::instance()->updateStatus();
        $info = UserRegisterService::instance()->getRegisterInfo();
        $info = (array)$info;

        // 创建用户的随机passwd
        $info['user_pass']                    = UserRegisterService::instance()->makePassword(6);
        $info['activating_time']              = time();
        $info['user_status']                  = UserEnum::REGISTER_STATUS_PASS;
        $info['relationship_cwop_user_id']    = $cwop_user_id;
        $info['relationship_cwop_account_id'] = $cwop_account_id;
        $info['relationship_cwop_accessToken']= $accessToken;
        self::setRequestUserInfoParams($info);

        BaseModel::transStart();
        //1.创建user_info
        $user_email = $this->oUserInfo->user_email;

        if (self::checkExits($user_email)) {
            $code = ProfessionErrorCodeEnum::ERROR_EMAIL_EXISTED;
            $msg  = ProfessionErrorCodeEnum::getErrorMessage();
            throw new Exception($msg[$code], $code);
        }

        $this->mUserInfoModel = new User_UserInfoModel();
        $aData                = $this->mUserInfoModel->mkUserParamsForInsert($this->oUserInfo);
        if ($this->checkExits())
            return NULL;
        if (!$user_id = $this->mUserInfoModel->insert($aData)) {
            BaseModel::transRollBack();
            return FALSE;
        }

        //2.创建个人设置
        UserPersonalSettingService::instance()->setRequestParams(array('user_id' => $user_id));

        if (!UserPersonalSettingService::instance()->createUserPersonalSet()) {
            BaseModel::transRollBack();
            return FALSE;
        }

        //3.关联user_register 和 user_info
        UserRegisterService::instance()->updateRelationshipUser($user_id);

        $oUserInfo = self::getUserInfoAll($user_id);

        if (empty($oUserInfo)) {
            BaseModel::transRollBack();
            return false;
        }

        //4.创建account_info
        if (empty($oUserInfo->channel)) {
            $oUserInfo->channel = PartnerEnum::CLOUDWISE;
        }

        self::setRequestUserInfoParams(array('package_id' => 0, 'channel' => $oUserInfo->channel));
        if (!$account_id = self::createAccount()) {
            BaseModel::transRollBack();
            return false;
        };

        //5.关联user_info 和 account_info
        if (!self::relationshipAccount($oUserInfo->user_id, $account_id)) {
            BaseModel::transRollBack();
            return false;
        }

        //6.创建company_info
        $oRegisterInfo = UserRegisterService::instance()->getRegisterInfoByRelationshipUser($oUserInfo->user_id);;
        $cParams = array(
            'company_name'     => $oRegisterInfo->company_name,
            'company_url'      => $oRegisterInfo->company_url,
            'company_industry' => $oRegisterInfo->company_industry,
            'account_id'       => $account_id,
        );

        CompanyService::instance()->setCompanyParamsForRequest($cParams);
        if (!CompanyService::instance()->createCompany()) {
            BaseModel::transRollBack();
            return false;
        }
        unset($cParams);

        //7.创建角色
        $rParams = array(
            array(
                'role_right' => UserEnum::USER_ROLE_ADMIN,
                'role_des'   => UserEnum::ADMIN_DES,
                'account_id' => $account_id,
            ),
            array(
                'role_right' => UserEnum::USER_ROLE_ADVANCED,
                'role_des'   => UserEnum::ADVANCED_DES,
                'account_id' => $account_id,
            ),
            array(
                'role_right' => UserEnum::USER_ROLE_READONLY,
                'role_des'   => UserEnum::READONLY_DES,
                'account_id' => $account_id,
            ),
        );
        RoleService::instance()->setRoleRequestParams($rParams[0]);
        if (!$role_id = RoleService::instance()->createRole()) {
            BaseModel::transRollBack();
            return false;
        }

        RoleService::instance()->setRoleRequestParams($rParams[1]);
        if (!RoleService::instance()->createRole()) {
            BaseModel::transRollBack();
            return false;
        }
        RoleService::instance()->setRoleRequestParams($rParams[2]);
        if (!RoleService::instance()->createRole()) {
            BaseModel::transRollBack();
            return false;
        }
        unset($rParams);

        //8.关联角色与用户
        $ruParams = array(
            'user_id' => $oUserInfo->user_id,
            'role_id' => $role_id,
        );
        RoleService::instance()->setRoleRequestParams($ruParams);
        if (!RoleService::instance()->createRoleUser()) {
            BaseModel::transRollBack();
            return false;
        }
        unset($ruParams);

        //9.创建分组
        $gParams = array(
            'group_name' => $oRegisterInfo->company_name,
            'parent_id'  => 0,
            'level'      => 1,
            'level_sort' => 1,
            'group_des'  => $oRegisterInfo->company_name,
            'account_id' => $account_id,
        );
        GroupService::instance()->setGroupRequestParams($gParams);
        if (!$group_id = GroupService::instance()->createGroup()) {
            BaseModel::transRollBack();
            return false;
        }

        unset($gParams);
        //10.分组与用户绑定
        $guParams = array(
            'group_id' => $group_id,
            'user_id'  => $oUserInfo->user_id,
        );
        GroupService::instance()->setGroupRequestParams($guParams);
        if (!GroupService::instance()->createGroupUser()) {
            BaseModel::transRollBack();
            return false;
        }
        unset($guParams);

        if (!self::updateUserStatusForActivate($oUserInfo->user_id)) {
            BaseModel::transRollBack();
            return false;
        }
        BaseModel::transCommit();
        return array(
            'user_id'    => $user_id,
            'account_id' => $account_id
        );
    }

    /**
     * 创建子用户
     */
    public function processCreateSubUser(VO_Request_DimSubUser $subUserInfo)
    {
        if (!UserService::instance()->exitsAccountIdCwopByAccountAndUser($subUserInfo->cwop_account_id, $subUserInfo->cwop_user_id)) {

            $userInfo['user_name']                    = $subUserInfo->user_name;
            $userInfo['user_email']                   = $subUserInfo->user_email;
            $userInfo['account_id']                   = $subUserInfo->account_id;
            $userInfo['user_pass']                    = $subUserInfo->user_pass;
            $userInfo['activating_time']              = isset($subUserInfo->activating_time) ? $subUserInfo->activating_time : '';
            $userInfo['user_status']                  = $subUserInfo->user_status;
            $userInfo['relationship_cwop_user_id']    = $subUserInfo->cwop_user_id;
            $userInfo['relationship_cwop_account_id'] = $subUserInfo->cwop_account_id;
            $userInfo['channel']                      = $subUserInfo->channel;

            self::setRequestUserInfoParams($userInfo);

            BaseModel::transStart();

            try {
                //1.创建user_info
                $user_email = $this->oUserInfo->user_email;

                if (self::checkExits($user_email)) {
                    $code = ProfessionErrorCodeEnum::ERROR_EMAIL_EXISTED;
                    $msg  = ProfessionErrorCodeEnum::getErrorMessage();
                    throw new Exception($msg[$code], $code);
                }

                $this->mUserInfoModel = new User_UserInfoModel();
                $aData                = $this->mUserInfoModel->mkUserParamsForInsert($this->oUserInfo);
                if ($this->checkExits())
                    return NULL;
                if (!$user_id = $this->mUserInfoModel->insert($aData)) {
                    BaseModel::transRollBack();
                    return FALSE;
                }

                //2.创建个人设置
                UserPersonalSettingService::instance()->setRequestParams(array('user_id' => $user_id));

                if (!UserPersonalSettingService::instance()->createUserPersonalSet()) {
                    BaseModel::transRollBack();
                    return FALSE;
                }

                $roleParams = array('user_id' => $user_id, 'role_id' => $subUserInfo->role_id);
                RoleService::instance()->setRoleRequestParams($roleParams);
                if (!RoleService::instance()->createRoleUser()) {
                    BaseModel::transRollBack();
                    throw new Exception(Lang::get('system.failed_create_role'));
                }

                $groupParams = array('user_id' => $user_id, 'group_id' => $subUserInfo->group_id);
                GroupService::instance()->setGroupRequestParams($groupParams);
                if (!GroupService::instance()->createGroupUser()) {
                    BaseModel::transRollBack();
                    throw new Exception(Lang::get('system.failed_create_group'));
                }


            } catch (Exception $e) {
                BaseModel::transRollBack();
                throw new Exception(Lang::get('system.failed_create_group'));
            }

            BaseModel::transCommit();

            return $user_id;
        } else {
            $where = array('relationship_cwop_account_id' => $subUserInfo->cwop_account_id, 'relationship_cwop_user_id' => $subUserInfo->cwop_user_id);

            $userInfo = $this->mUserInfoModel->fetchRow($where);

            if (!$userInfo)
                return FALSE;

            return $userInfo->user_id;
        }
    }

    /**
     * 用户激活
     * @param $oUserInfo
     * @return bool
     */
    public function userActivating($oUserInfo)
    {
        /*if (empty($oUserInfo))
            return FALSE;
        //创建account
        if (empty($oUserInfo->channel)) {
            $oUserInfo->channel = 1;
        }
        BaseModel::transStart();
        self::setRequestUserInfoParams(array('package_id' => 0, 'channel' => $oUserInfo->channel));
        if (!$account_id = self::createAccount()) {
            BaseModel::transRollBack();
            return false;
        };
        if (!self::relationshipAccount($oUserInfo->user_id, $account_id)) {
            BaseModel::transRollBack();
            return false;
        }

        //创建company_info
        $oRegisterInfo = UserRegisterService::instance()->getRegisterInfoByRelationshipUser($oUserInfo->user_id);;
        $cParams = array(
            'company_name'     => $oRegisterInfo->company_name,
            'company_url'      => $oRegisterInfo->company_url,
            'company_industry' => $oRegisterInfo->company_industry,
            'account_id'       => $account_id,
        );

        CompanyService::instance()->setCompanyParamsForRequest($cParams);
        if (!CompanyService::instance()->createCompany()) {
            BaseModel::transRollBack();
            return false;
        }

        unset($cParams);
        //创建个人设置

        UserPersonalSettingService::instance()->setRequestParams(array('user_id' => $oUserInfo->user_id));

        if (!UserPersonalSettingService::instance()->createUserPersonalSet()) {
            BaseModel::transRollBack();
            return false;
        }

        //创建角色
        $rParams = array(
            array(
                'role_right' => UserEnum::USER_ROLE_ADMIN,
                'role_des'   => '全部权限',
                'account_id' => $account_id,
            ),
            array(
                'role_right' => UserEnum::USER_ROLE_ADVANCED,
                'role_des'   => '管理和查看监控任务',
                'account_id' => $account_id,
            ),
            array(
                'role_right' => UserEnum::User_ROLE_READONLY,
                'role_des'   => '查看监控任务',
                'account_id' => $account_id,
            ),
        );
        RoleService::instance()->setRoleRequestParams($rParams[0]);
        if (!$role_id = RoleService::instance()->createRole()) {
            BaseModel::transRollBack();
            return false;
        }

        RoleService::instance()->setRoleRequestParams($rParams[1]);
        if (!RoleService::instance()->createRole()) {
            BaseModel::transRollBack();
            return false;
        }
        RoleService::instance()->setRoleRequestParams($rParams[2]);
        if (!RoleService::instance()->createRole()) {
            BaseModel::transRollBack();
            return false;
        }
        unset($rParams);
        //角色与用户绑定
        $ruParams = array(
            'user_id' => $oUserInfo->user_id,
            'role_id' => $role_id,
        );
        RoleService::instance()->setRoleRequestParams($ruParams);
        if (!RoleService::instance()->createRoleUser()) {
            BaseModel::transRollBack();
            return false;
        }
        unset($ruParams);

        //创建分组
        $gParams = array(
            'group_name' => $oRegisterInfo->company_name,
            'parent_id'  => 0,
            'level'      => 1,
            'level_sort' => 1,
            'group_des'  => $oRegisterInfo->company_name,
            'account_id' => $account_id,
        );
        GroupService::instance()->setGroupRequestParams($gParams);
        if (!$group_id = GroupService::instance()->createGroup()) {
            BaseModel::transRollBack();
            return false;
        }

        unset($gParams);
        //分组与用户绑定
        $guParams = array(
            'group_id' => $group_id,
            'user_id'  => $oUserInfo->user_id,
        );
        GroupService::instance()->setGroupRequestParams($guParams);
        if (!GroupService::instance()->createGroupUser()) {
            BaseModel::transRollBack();
            return false;
        }
        unset($guParams);
        BaseModel::transCommit();
        return $account_id;*/
    }

    /**
     * 更新用户为激活状态
     * @param $user_id
     * @return bool
     */
    public function updateUserStatusForActivate($user_id)
    {
        if (!$user_id)
            return FALSE;
        $aUpdate = array('user_status' => UserEnum::USER_STATUS_NORMAL, 'activating_time' => time());
        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    /*
     * 修改密码
     * @param $password
     * @return bool
     */
    public function modifyPassword($password, $user_id = NULL)
    {
        if (is_null($user_id)) {
            $user_id = self::getUserCache()->user_id;
        }

        if (!$password)
            return FALSE;
        $ticket      = Cookie::get(CacheKeyEnum::USER_INFO_COOKIE_KEY);
        $newPassword = md5(substr($ticket, 0, 8) . $password);
        $aUpdate     = array('user_pass' => $newPassword);

        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    public function updateUserPass($user_id, $pass)
    {
        $ticket      = md5(time() . $pass);
        $newPassword = md5(substr($ticket, 0, 8) . $pass);
        $aUpdate     = array('user_pass' => $newPassword, 'user_ticket' => $ticket);
        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    /**
     * 修改用户信息
     * @return bool
     */
    public function modifyUserInfo()
    {
        $aUpdate = $this->mUserInfoModel->mkUserParamsForUpdate($this->oUserInfo);
        $user_id = $this->oUserInfo->user_id;
        if (!$user_id)
            $user_id = self::getUserCache()->user_id;

        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    public function updateUserInfoFromCwop($update, $user_id)
    {
        foreach ($update as $k => $v) {
            if (!$v) {
                unset($update[$k]);
            }
        }
        return $this->mUserInfoModel->update($update, $user_id);

    }

    /**
     * 修改用户email
     *
     * @param $email
     * @return bool
     */
    public function modifyUserEmail($email)
    {
        if (!$email)
            return FALSE;
        $user_id = self::getUserCache()->user_id;
        if (!$user_id)
            return FALSE;
        $aUpdate = array('user_email' => $email);

        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    /*
     * 用户迁移，从用户组1到用户组2
     */
    public function changeGroupUsersGroup($group1, $group2)
    {
        $mUserGroupModel = new User_UserGroupModel();
        $mUserGroupModel->setTableToJoinTable();
        $mUserGroupModel->update(array('group_id' => $group2), $group1);
    }

    /*
     * 删除用户组
     */
    public function deleteGroup($group_id)
    {
        $mUserGroupModel = new User_UserGroupModel();
        $mUserGroupModel->setTableToJoinTable();
        $users = $mUserGroupModel->getGroupUsers($group_id);
        if ($users) {
            return FALSE;
        } else {
            $mUserGroupModel = new User_UserGroupModel();
            return $mUserGroupModel->deleteGroup($group_id);
        }
    }

    /*
     * 获取企业的顶级部门
     */

    public function getAccountTopGroup($account_id)
    {
        $mGroupModel = new User_UserGroupModel();
        $mGroupModel->setSelect(array('group_id'));

        $awhere = array(
            'account_id' => $account_id,
            'parent_id'  => 0,
            'level'      => 1
        );
        $group  = $mGroupModel->fetchRow($awhere);
        return $group->group_id;
    }

    /**
     * 修改用户状态
     * @param $user_id
     * @param $status
     * @return bool
     */
    public function modifyUserStatus($user_id, $status)
    {
        if (!$user_id || !$status)
            return FALSE;
        $aUpdate = array('user_status' => $status);

        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    /**
     * 添加邀请用户
     * @param array $params
     * @return bool
     */
    public function addAccountUser(array $params)
    {
        //添加user_info
        $subUserParams['group_id']        = $params['group_id'];
        $subUserParams['role_id']         = $params['role_id'];
        $subUserParams['user_name']       = $params['user_name'];
        $subUserParams['user_email']      = $params['user_email'];
        $subUserParams['account_id']      = $params['account_id'];
        $subUserParams['user_pass']       = $params['user_pass'];
        $subUserParams['cwop_user_id']    = $params['relationship_cwop_user_id'];
        $subUserParams['cwop_account_id'] = $params['relationship_cwop_account_id'];
        $subUserParams['channel']         = $params['channel'];

        $subUserInfo = self::setRequestSubUserParams($subUserParams);
        BaseModel::transStart();

        $user_id = self::processCreateSubUser($subUserInfo);

        if (!$user_id) return FALSE;

        if (!UserService::instance()->updateUserInfoCwopAccessToken($params['relationship_cwop_user_id'], $params['relationship_cwop_account_id'], $params['relationship_cwop_accessToken']))
        {
            BaseModel::transRollBack();
            return false;
        }

        BaseModel::transCommit();

        //发送激活邮件
        $token = md5(time() . $user_id . $this->oUserInfo->user_email);
        MailService::instance()->sendByMQ('emails.user.user_activate', array(
            'user_name' => $this->oUserInfo->user_name,
            'password'  => $this->oUserInfo->user_pass,
            'token'     => $token,
        ), $this->oUserInfo->user_email, $this->oUserInfo->user_name, 'yacebao.com');
        //生成cache
        CacheService::instance()->set($token, $this->oUserInfo->user_email, CacheExpireEnum::EXPIRE_ACTIVE_EMAIL);

        return TRUE;
    }

    /**
     * @param null $iAccountId
     * @return array
     */
    public function getUserList($iAccountId = NULL)
    {
        $iAccountId = is_null($iAccountId) ? self::$getUserCache->account_id : $iAccountId;

        return $this->mUserInfoModel->getAccountUserId($iAccountId);

    }


    /**
     * @param $account_id
     * @param $group_ids
     * @return mixed
     */
    public function getUserGroupsByAccount($account_id, $group_ids)
    {
        $mGroup = new User_UserGroupModel();
        $data   = $mGroup->getUserGroupsByAccount($account_id, array(0), $group_ids);
        return $data;
    }

    /**
     * @param $account_id
     * @param $group_id
     * @param $user_ids
     * @return array
     */
    public function getUsersByGroup($account_id, $group_id, $user_ids = array(0))
    {
        $mGroup = new User_UserGroupModel();
        $data   = $mGroup->getUsersByGroup($account_id, $group_id, $user_ids);
        return $data;
    }

    public function getGroupUserItems($params)
    {
        switch ($params['type']) {
            case 'group':
                $mGroup         = new Project_GroupInfoModel();
                $data['groups'] = $mGroup->fetchAll(array('group_id in ' => $params['list']));
                break;
            case 'user':
                $mUser         = new User_UserInfoModel();
                $data['users'] = $mUser->fetchAll(array('user_id in ' => $params['list']));
        }
        return $data;
    }

    /**
     * 获取当前组信息
     */
    public function getCurrentGroupInfo(){
        $account_id = self::$getUserCache->account_id;
        $mGroup = new User_UserGroupModel();
        $groupInfo =  $mGroup->fetchRow(array('account_id'=> $account_id));
        return $groupInfo;
    }
}