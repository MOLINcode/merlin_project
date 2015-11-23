<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-7-31
 * Time: 下午11:57
 */
namespace app\Constants;
class AjaxLoadErrorTplEnum {
    const REPORT_ERR = 1;
    const NETWORK_REPORT_ERR1 = 2;
    const MONITOR_LIST_ERR = 3;
    const NO_INSTALL_AGENT_ERR = 4;
    const UNFINISHED_AGENT_ERR = 5;

    static public $errorTpl = array(
        self::REPORT_ERR => 'dispatch.reportError', //no data没有数据
        self::NETWORK_REPORT_ERR1 => 'dispatch.NetReportError1',
        self::MONITOR_LIST_ERR => 'dispatch.monitorListError',
        self::NO_INSTALL_AGENT_ERR => 'dispatch.noInstallAgent',
        self::UNFINISHED_AGENT_ERR => 'dispatch.unfinishedAgent',
    );

    static public function getNoDataInfo(){
        $no_data_info = <<<EOT
<div class="nodata"></div>
EOT;
        return $no_data_info;
    }
    static public function getMicroNoDataInfo(){
        $micro_no_data_info = <<<EOT
<div class="micronodata"></div>
EOT;
        return $micro_no_data_info;
    }
    static public function getCreateTaskErrInfo(){
        return Lang::get('common.create_task_failed');
    }

    static public function getUpdateTaskErrInfo(){
        return Lang::get('common.modify_task_failed');
    }

    static public function getDelTaskErrInfo(){
        return Lang::get('common.delete_task_failed');
    }

    //输出错误信息
    static public function outputErrorInfo($errInfo='',$height='300px'){
        $no_data_info = <<<EOT
<div class="nodata" style="height:$height">$errInfo</div>
EOT;
        echo $no_data_info;
        exit;
    }
} 