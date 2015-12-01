<?php
namespace App\Services\Tool;
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-7-31
 * Time: 下午12:07
 */
class ToolKit
{
    /**
     * 生成随机验证码
     * @param int $length
     * @return string
     */
    public static function mkValidatorCode( $length = 6)
    {
        $string = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTxXyYzZ0123456789";
        $key = '';
        for($i=0;$i<$length;$i++)
        {
            $key .= $string{mt_rand(0,strlen($string)-1)};//生成php随机数
        }
        return $key;
    }

    /**
     * 生成随机密码
     * @param int $length
     * @return string
     */
    public static  function mkPassword($length = 6)
    {
        $pattern = '1234567890@#$%^&*abcdefghijklmnopqrstuvwxyz';
        $key = '';
        for($i=0;$i<$length;$i++)
        {
            $key .= $pattern{mt_rand(0,strlen($pattern)-1)};//生成php随机数
        }
        return $key;
    }

    /**
     * 对多维数组排序
     * @param        $arr
     * @param        $keys
     * @param string $type
     * @return array
     * @example
     * $arr = array(
    array('name'=>'手机','brand'=>'诺基亚','price'=>1050),
    array('name'=>'笔记本电脑','brand'=>'lenovo','price'=>4300)
    ),
     * self::array_sort($arr,'price','desc')
     */
    public static function array_sort($arr,$keys,$type='asc')
    {
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v){
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keysvalue);
        }else{
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k=>$v){
            $new_array[] = $arr[$k];
        }
        return $new_array;
    }

    /**
     * 获取字符串的字母和数字
     */
    public static function getLetterNum($str){
        $pattern = '/[^a-zA-Z0-9]/i';
        $replacement = '';
        return preg_replace($pattern, $replacement,$str);
    }

    /**
     * 字节转换成M
     */
    public static function ByteIntoM($bytes,$median=2){
        return round($bytes/(1024*1024),2);
    }

    /**
     * 字节转换成G
     */
    public static function ByteIntoG($bytes,$median=2){
        return round($bytes/(1024*1024*1024),2);
    }

    /**
     * kb转换成G
     */
    public static function KbIntoG($bytes,$median=2){
        return round($bytes/(1024*1024),2);
    }
    /**
     * 匹配字符串中包含http或Http
     */
    public static function regexHttp($str){
        $regex = '/http|Http/';
        return preg_match($regex,$str);
    }

    /**
     * 制作分页列表
     * @param        $current_page_num 当前页码数
     * @param        $total_num 总的页码数
     * @param string $class 每个页码的CSS class名称
     * @return string
     */
    public static function makePageList($current_page_num,$total_num,$class = 'page_list_class'){


        //页码范围计算
        $init = 1;//起始页码数
        $max = $total_num;//结束页码数
        $pagelen = 7;//要显示的页码个数
        $pagelen = ($pagelen % 2) ? $pagelen : $pagelen + 1;//页码个数
        $pageoffset = ($pagelen - 1)/2;//页码个数左右偏移量
        //分页数大于页码个数时可以偏移
        if($total_num > $pagelen){
            //如果当前页小于等于左偏移
            if($current_page_num <= $pageoffset){
                $init = 1;
                $max = $pagelen;
            }else{//如果当前页大于左偏移
                //如果当前页码右偏移超出最大分页数
                if($current_page_num +$pageoffset >= $total_num+1){
                    $init = $total_num - $pagelen + 1;
                }else{
                    //左右偏移都存在时的计算
                    $init = $current_page_num - $pageoffset;
                    $max = $current_page_num + $pageoffset;
                }
            }
        }

        $pageList = '';
        $pageList .= '<div style="margin-bottom:80px; margin-right:20px;">';
        $pageList .= '<ul class="pagination pull-right">';
        if($current_page_num == 1){
            $pageList .= '<li class="disabled"><span style="color: #B6C4C9">«</span></li>';
        }else{
            $pageList .= '<li><a href="javascript:void(0);" class="'.$class.'" page_num="'.($current_page_num-1).'">«</a></li>';
        }

        for($i = $init;$i <= $max;$i++){
            if($i == $current_page_num)
                $pageList .= '<li class="active"><span>'.$current_page_num.'</span></li>';
            else
                $pageList .= '<li><a href="javascript:void(0);" class="'.$class.'" page_num="'.$i.'">'.$i.'</a></li>';
        }

        if($current_page_num == $total_num){
            $pageList .= '<li class="disabled"><span style="color: #B6C4C9">»</span></li>';
        }else{
            $pageList .= '<li><a href="javascript:void(0);" class="'.$class.'" page_num="'.($current_page_num+1).'">»</a></li>';
        }
        $pageList .= '</ul></div>';

        return $pageList;
    }

    static public function checkEmailFormat($email){

        if (preg_match("/^[a-z0-9]([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?$/i",$email)){
            return true;
        }
        else {
            return false;
        }

    }

    /**
     * @param $data
     *
     * @return array
     */
    static function disposeChartTableData($data)
    {
        $newData = array();
        if(!$data){
            return $newData;
        }
        $newData['table_data'] = $data['table_data'];
        $newData['labels'] = array();
        $newData['data'] = array();
        if(array_key_exists('show_data',$data['chart_data'])){
            $data['chart_data']['showData'] = $data['chart_data']['show_data'];
            unset($data['chart_data']['show_data']);
        }
        if(array_key_exists('showData',$data['chart_data'])){
            if(count($data['chart_data']['showData'])){
                foreach($data['chart_data']['showData'] as $v){
                    array_push($newData['labels'],$v['time']);
                    unset($v['time']);
                    foreach($v as $k1=>$v1){
                        $newData['data'][$k1][]=$v1;
                    }
                }
            }else{
                return $newData;
            }
        }

        return $newData;
    }

    /**
     * 处理前端图表数据，以适应新的echarts数据结构
     */
    static function disposeChartData($data){
        $newData = array();
        if(!$data){
            return $newData;
        }
        if(array_key_exists('show_data',$data)){
            $data['showData'] = $data['show_data'];
            unset($data['show_data']);
        }
        if(array_key_exists('showData',$data)){
            if(array_key_exists('legend',$data['labels'])){
                $newData['name'] = $data['labels']['name'];
                $newData['data'] = array();
                if(count($data['showData'])){
                    foreach($data['showData'] as $v){
                        $newData['data'][$v['name']] = $v['value'];
                    }
                }
            }else{
                $newData['labels'] = array();
                $newData['data'] = array();
                if(count($data['showData'])){
                    foreach($data['showData'] as $v){
                        array_push($newData['labels'],$v['time']);
                        unset($v['time']);
                        foreach($v as $k1=>$v1){
                            $newData['data'][$k1][]=$v1;
                        }
                    }
                }
            }
        }else if(array_key_exists('mapData',$data)){
            if(count($data['mapData']['data'])){
                $max = 0;
                if(isset($data['mapData']['unit'])){
                    $unit = $data['mapData']['unit'];
                }else{
                    $unit = '';
                }
                foreach($data['mapData']['data'] as $value){
                    if($value['value']>=$max){
                        $max = $value['value'];
                    }
                    $newData[$value['name']] = $value['value'];
                }
                $newData['list'] = array();
                foreach($data['mapRightListData']['listData'] as $value){
                    $value['value'] .= $unit;
                    array_push($newData['list'],$value);
                }
                $newData['head_value'] = $max.$unit;
            }
        }
        return $newData;
    }
    //mysql缓存适应新的图表数据
    public static function disposeMysqlQueryCacheData($data){
        $newData = array();
        $newData['table_data'] = $data['table_data'];
        unset($data['table_data']);
        foreach($data as $key=>$tipData){
            $newData[$key] = array(
                'labels'=>array(),
                'data'=>array(),
            );
            if(count($tipData['showData'])){
                foreach($tipData['showData'] as $v){
                    array_push($newData[$key]['labels'],$v['time']);
                    unset($v['time']);
                    foreach($v as $k1=>$v1){
                        $newData[$key]['data'][$k1][]=$v1;
                    }
                }
            }
        }
        return $newData;
    }

    /**
     * @param $tree
     */
    public static function printTreetList($treeData)
    {
        echo "<ul>";
        foreach ($treeData as $v) {
            if (ToolKit::checkChild($v)) {
                echo "<li>";
                echo '<span> <i class="fa fa-folder-open"> </i> 节点
                </span><a id="' . $v["id"] . '"> ' . $v["cName"] . '</a>';
                ToolKit::printTreetList($v['child']);
                echo "</li>";
            } else {
                echo "<li >";
                echo '<span> <i class="fa fa-folder-open"> </i> 节点
                </span><a id="' . $v["id"] . '"> ' . $v["cName"] . '</a>';
                echo "</li>";
            }
        }
        echo "</ul>";
    }

    /**
     * @param $array
     * @return bool
     */
    public static function checkChild($array)
    {
        if (array_key_exists("child", $array)) {
            return true;
        } else {
            return false;
        }
    }

}