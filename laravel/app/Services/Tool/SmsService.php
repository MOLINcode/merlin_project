<?php
/**
 * Created by PhpStorm.
 * User: thor
 * Date: 14-7-27
 * Time: 下午5:36
 */
namespace App\Services\Tool;
use App\Services\BaseService;
class SmsService extends BaseService{
    private static $self = NULL;

    public static function instance(){
        if (self::$self == NULL) {
            self::$self = new self;
        }
        return self::$self;
    }

    private $oMQService = NULL;

    public function __construct(){

    }

    private function processMQService(){
        $this->oMQService = MQRedisService::instance();
        $this->oMQService->setQName('sendSms');
    }

    /**
     * 直接发送短信
     * 此方法已经废除
     * @param $to
     * @param $body
     * @return bool
     */
    public function sendSms_old($to, $body)
    {
        $sms_config = SmsEnum::getSmsConfig();

        $uid =  $sms_config[SmsEnum::SMS_SEND_TWO]['uid'];

        //短信接口密码 $passwd
        $passwd = $sms_config[SmsEnum::SMS_SEND_TWO]['pwd'];
        $body = iconv("UTF-8", "GBK", $body);
        $gateway =  $sms_config[SmsEnum::SMS_SEND_TWO]['url'];

        $curl = curl_init();
        $fields_string = "CorpID={$uid}&Pwd={$passwd}&Mobile={$to}&Content={$body}&Cell=&SendTime=";
        curl_setopt_array($curl, array(
            CURLOPT_URL => $gateway,
            CURLOPT_TIMEOUT => SmsEnum::SMS_CURL_CURLOPT_TIMEOUT,
            CURLOPT_HEADER => 0,
            CURLOPT_NOBODY => 0,
            CURLOPT_POST=>6,
            CURLOPT_POSTFIELDS=>$fields_string,
            CURLOPT_RETURNTRANSFER=>1,
        ));
        $ret_body = trim(curl_exec($curl));

        $err_str = curl_errno($curl) . ':' . curl_error($curl);
        curl_close($curl);
        if($ret_body!='1' &&  $ret_body !='0'){
            echo $err_str;
            //@to do   写错误日志
            return false;
        }
        return true;
    }

    private $sRestClient;

    /**
     * 直接发送手机短信
     * @param $to
     * @param $body
     * @return bool
     */
    public function SendSms($to, $body){
        $sms_config = SmsEnum::getSmsConfig();

        $uid =  $sms_config[SmsEnum::SMS_SEND_TWO]['uid'];

        //短信接口密码 $passwd
        $passwd = $sms_config[SmsEnum::SMS_SEND_TWO]['pwd'];
        $body = iconv("UTF-8", "GBK", $body);
        $gateway =  $sms_config[SmsEnum::SMS_SEND_TWO]['url'];
        $fields_string = "CorpID={$uid}&Pwd={$passwd}&Mobile={$to}&Content={$body}&Cell=&SendTime=";

        $this->sRestClient = REST_Client::instance();
        $this->sRestClient->setMethod(REST_Client::METHOD_POST);
        $this->sRestClient->setApi($gateway);
        $this->sRestClient->setData($fields_string);
        $this->sRestClient->go();
        $result = $this->sRestClient->getBody();
        if($result!='1' &&  $result !='0'){

            //@to do   写错误日志
            return false;
        }
        return  true;
    }

    /**
     * 塞入队列
     * @param $sTel
     * @param $sBody
     * @return mixed
     */
    public function sendByMQ($sTel, $sBody)
    {
        self::processMQService();

        $rawParams = array(
            'sTel'        => $sTel,
            'sBody'       => $sBody,
        );

        $request = VO_Bound::Bound($rawParams, NEW VO_Request_DimSendSms());

        return $this->oMQService->push(serialize($request));
    }

    /**
     * 运用队列发送
     * @return mixed
     *
     * @todo log it
     */
    public function processSmsWithMQ()
    {
        self::processMQService();

        while (TRUE) {
            $result = self::_getSmsPop();

            if (!$result) die;

            self::sendSms($result->sTel, $result->sBody);

        }

        return TRUE;
    }

    /**
     * @return bool|mixed
     */
    private function _getSmsPop(){
        $result = $this->oMQService->pop();
        if (!$result) return FALSE;

        return unserialize($result);
    }

}