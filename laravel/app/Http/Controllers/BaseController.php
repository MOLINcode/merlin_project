<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Services\Tool\CacheService;
use App\Services\Tool\RESTService;
use App\Constants\ErrorCodeEnum;
use App\Constants\UserMenuEnum;
use Request;
use Validator;
use View;
use Route;

/**
 * Class BaseController
 */
class BaseController extends Controller
{

    protected $params = NULL;

    protected $layout = 'layouts.master';

    /**
     * @var RESTService
     */
    protected $rest = NULL;

    /**
     * @var CacheService
     */
    protected $cache = NULL;

    /**
     * @var VO_Response_UserCache
     */
    protected $userInfo = NULL;

    protected $language = NULL;

    public function __construct()
    {
        $this->rest   = RESTService::instance();
        $this->cache  = CacheService::instance();
        $this->params = Request::All();

    }

    protected function getParam($sParamKey, $default = NULL)
    {
        if (array_key_exists($sParamKey, $this->params)) {
            $result = $this->params[$sParamKey];
        } else {
            $result = Route::input($sParamKey);
        }
        return !is_null($result) ? $result : $default;
    }

    /**
     * 获取php://input的原始数据流
     */
    protected function getPhpInputFlow(){
        return file_get_contents("php://input");
    }

    /**
     * 表单验证
     * @param array $rules			验证规则
     * @param array $messages       自定义消息
     * @return \Illuminate\Http\RedirectResponse
     */
    public function baseValidate(array $rules,array $messages = array()){

        return  Validator::make($this->params, $rules,$messages);
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
           $this->layout = view($this->layout);
        }
    }

    /**
     * @param $template
     * @param string $spall
     * @return mixed
     */
    protected function view($template, $spall = 'content',$flag=false)
    {
        $this->layout = View::make($this->layout);
        $this->layout->$spall   = view($template);
        if($flag){
            $this->layout->front_header = view('layouts.front_common.head');
        }else{
            $this->layout->front_header = view('layouts.admin_common.head');
            $this->layout->front_left = view('layouts.admin_common.left')->with(array(
                'leftMenus' => UserMenuEnum::getLeftMenu(),
            ));
        }
        return $this->layout->$spall;
    }

    /**
     * @param $template
     * @param string $spall
     * @return mixed
     */
    protected function viewAjax($template, $spall = 'content')
    {
        $this->layout         = View::make('layouts.ajax_master');
        $this->layout->$spall = View::make($template);
        return $this->layout->$spall;
    }


    /**
     * 业务验证错误信息
     * @param array $validator_rule 验证规则
     * @param array $error_message 错误编号
     * @return mixed
     */
    protected function validatorError(array $validator_rule, array $error_message)
    {
//        dd($error_message);
        foreach ($validator_rule as $filed => $rules) {
//            dd($filed,$rules);
            if (!is_array($rules)) {
                $rules = explode('|', $rules);
            }

            foreach ($rules as $key => $rule) {
//                dd($key,$rule);
                $validator = Validator::make(array($filed => $this->params[$filed]), array($filed => $rule));
                if ($validator->fails()) {
                    $this->rest->error(NULL, $error_message[$filed][$key], array('filed' => $filed));
                }
            }
        }
        return TRUE;
    }

    /**
     * 业务错误信息
     * @param $code
     * @return mixed
     */
    protected function professionError($code)
    {
        $this->rest->error(NULL, $code);
    }

}
