<?php
/**
 * 数据列表,格式化数据
 * @author Neeke.Gao
 *
 *demo
 *    $this->mkData = REST_PagingData::instance();
 *    $this->mkData->setOffset(0,5); 不采用setOffset方法时,将从POST中取得start & limit 值
 *    $this->mkData->config(30, 'brief_id');
 *    $this->data = $this->mkData->make($data);
 */
namespace App\Services\REST;
class REST_PagingData extends BaseService
{

    /**
     * 分页初始值
     * @var int
     */
    private $start = 0;

    /**
     * 分页长度
     * @var int
     */
    private $limit = 0;
    const DEFAULT_LIMIT = 10;

    /**
     * 总数
     * @var int
     */
    private $total = 0;

    /**
     * 指定主键
     * @var string
     */
    private $PrimaryKey = '';

    /**
     * 是否可选中
     * @var bool
     */
    private $checkable = FALSE;


    private $ifSetOffset = FALSE;
    /**
     * @var REST_PagingData
     */
    private static $self = NULL;

    /**
     * @static
     * @return REST_PagingData
     */
    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }
        return self::$self;
    }

    /**
     * 初始化配置型
     * @param int $total 数据总量
     * @param string $PrimaryKey 主键
     * @param bool $checkable 是否可选
     */
    public function config($total, $PrimaryKey, $checkable = FALSE)
    {
        if ($this->ifSetOffset == FALSE) {
            self::setOffset();
        }
        $this->total      = (int)$total;
        $this->PrimaryKey = (string)$PrimaryKey;
        $this->checkable  = (bool)$checkable;
    }

    /**
     * 设置start limit值
     * @param bool|int $start 分页初始值
     * @param bool $limit
     * @internal param int $count 分页长度
     */
    public function setOffset($start = FALSE, $limit = FALSE)
    {
        $this->ifSetOffset = TRUE;
        $this->start       = $start != FALSE ? (int)$start : (isset($_POST['start']) ? (int)$_POST['start'] : 0);
        $this->limit       = $limit != FALSE ? (int)$limit : (isset($_POST['limit']) ? (int)$_POST['limit'] : self::DEFAULT_LIMIT);
    }

    /**
     * 取得当前配置
     * @return array
     */
    public function getConfig()
    {
        return array(
            'start'      => $this->start,
            'limit'      => $this->limit,
            'total'      => $this->total,
            'primarykey' => $this->PrimaryKey,
        );
    }

    /**
     * 组装数据
     * @param array $data_
     * @return array
     */
    public function make($data_ = array())
    {
        $data = array(
            'start'     => $this->start,
            'limit'     => $this->limit,
            'total'     => isset($this->total) ? $this->total : 0,
            'checkable' => $this->checkable,
        );

        if ((!is_array($data_) || count($data_) < 1) && !is_object($data_)) {
            $data['rows'] = 0;
        } else {
            foreach ($data_ as $k => $v) {
                if (is_object($v)) $v = $v->toArray();
                $data['rows'][$k]['id']    = $v[$this->PrimaryKey];
                $data['rows'][$k]['cells'] = $v;
            }
        }

        return $data;
    }

}