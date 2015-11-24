<?php
/**
 *
 * Class UserService
 */
namespace App\Services\User;
use App\Services\BaseService;
use App\Models\User\UserRegisterModel;
class UserService extends BaseService
{
    private static $self = NULL;
    public $oRegister;

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
        $this->oRegister = new UserRegisterModel();
    }




}