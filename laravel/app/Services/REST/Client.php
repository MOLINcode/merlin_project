<?php
/**
 * RestClient
 * @author Neeke.Gao
 *
 * demo
 *        $data = array(
 *            'param1' => 'test',
 *            'param2' => 'test',
 *            );
 *
 *        $this->c = REST_Client::instance();
 *        $this->c->setMethod(REST_Client::METHOD_POST);
 *        $this->c->setData($data);
 *        $this->c->setApi('http://www.baidu.com');
 *        $this->c->go();
 *        $body = $this->c->getBody();
 *        var_dump($body);
 */
namespace App\Services\REST;
class REST_Client extends BaseService
{
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';
    const METHOD_PUT    = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /**
     * @var REST_Client
     */
    private static $self = NULL;

    /**
     * @static
     * @return REST_Client
     */
    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    private $header = NULL;

    function getHeader()
    {
        return $this->header;
    }

    public function setHeader($key,$value)
    {
        $this->header[$key] = $value;
        return $this->header;
    }

    private $contentType = 'Content-Type: Application/json;charset=utf-8';
    public function setContentType($value){
        $this->contentType = 'Content-Type: '.$value.';charset=utf-8';
    }

    private $body = NULL;

    function getBody()
    {
        return $this->body;
    }

    /**
     * method方法
     * @var (string)GET|POST|PUT|DELETE
     */
    private $method = self::METHOD_GET;

    public function setMethod($method = self::METHOD_GET)
    {
        $this->method = $method;
    }

    /**
     * api url
     * @var (string)url
     */
    private $api = NULL;

    public function setApi($api = NULL)
    {
        $this->api = $api;
    }

    /**
     * GET或POST的请求参数
     * @var (array)请求参数
     */
    private $data = array();
    private $ifData = FALSE;

    public function setData($data)
    {
        $this->ifData = TRUE;
        $this->data   = $data;
    }

    /**
     * 设置referer来源
     * @var (string)referer
     */
    private $referer = NULL;
    private $ifReferer = FALSE;

    public function setReferer($referer)
    {
        $this->ifReferer = TRUE;
        $this->referer   = $referer;
    }

    /**
     * 走起
     */
    public function go()
    {
        self::valid();
        self::myCurl();
    }

    private function valid()
    {
        if ($this->api == NULL) {
            throw new Exception('$this->api can not be null');
        }

        if ($this->ifData) {
            if (
                (is_array($this->data) && count($this->data) < 1)
                || (is_string($this->data) && strlen($this->data) < 1)
            ) {
                throw new Exception('$this->data is empty');
            }

        }

        if ($this->ifReferer && (strlen($this->referer) < 1)) {
            throw new Exception('$this->referer is empty');
        }

        if ($this->method != 'GET' && !in_array($this->method, array('POST', 'PUT', 'DELETE'))) {
            throw new Exception('$this->method is error');
        }
    }

    private function myCurl()
    {
        $ch        = curl_init();
        $timeout   = 300;
        $useragent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";
        $header    = array('Accept-Language: zh-cn', 'Connection: Keep-Alive', 'Cache-Control: no-cache');
        array_push($header,$this->contentType);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        switch ($this->method) {
            case self::METHOD_GET:
                if (is_array($this->data) && count($this->data) > 0) {
                    $this->api .= '?' . http_build_query($this->data);

                }
                curl_setopt($ch, CURLOPT_URL, $this->api);
                break;
            case self::METHOD_POST:
                if (is_array($this->data)) {
                    //$this->data = http_build_query($this->data);
                    $this->data = json_encode($this->data);
                }
                curl_setopt($ch, CURLOPT_URL, $this->api);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
                //curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));
                break;
            case self::METHOD_PUT:
                curl_setopt($ch, CURLOPT_PUT, TRUE);
                break;
            case self::METHOD_DELETE:
                curl_setopt($ch, CURLOPT_URL, $this->api);
                curl_setopt($ch, CURLOPT_FILETIME, TRUE);
                curl_setopt($ch, CURLOPT_FRESH_CONNECT, FALSE);
                curl_setopt($ch, CURLOPT_NOSIGNAL, TRUE);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, self::METHOD_DELETE);
                break;
        }

        if ($this->ifReferer) {
            curl_setopt($ch, CURLOPT_REFERER, $this->referer);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        if (curl_errno($ch)) {
            throw new Exception('CURL was error');
        } else {
            $this->body   = curl_exec($ch);
            $this->header = curl_getinfo($ch);
        }

        curl_close($ch);
    }

}