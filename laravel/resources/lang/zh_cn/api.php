<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-9-2
 * Time: 下午3:01
 */

return array(
    'externalApi' => array(
        'book_time_error'               => '预约时间不能小于当前时间',
        'success'                       => '成功',
        'args_not_enough'               => '参数不完整',
        'interface_anomaly'             => '接口异常',
        'not_allow_appoint'             => '预约时间段内没有相关可用资源,请申请别的时间段或者资源',
        'fail'                          => '失败',
        'front_create_test_fail'        => '前端创建测试任务实例失败！',
        'admin_appoint_fail'            => '后端预约失败！',
        'admin_appoint_fail_not_code'   => '后端预约失败并且statusCode的值不存在',
        'create_test_fail'              => '创建测试任务实例失败！',
        'send_scene_success'            => '发送测试场景内容成功！',
        'send_scene_fail'               => '发送测试场景内容失败：',
        'send_modify_status_fail'       => '发送要修改的任务状态失败！',
        'modify_status_success'         => '更改任务状态成功',
        'modify_status_fail'            => '更改任务状态失败！',
    ),
    'ycbApi' => array(
        'request_args'                  => '请求参数',
        'no_content'                    => '没有获取内容',
        'no_scene'                      => '场景为空',
        'invalid_status'                => '传入的状态值status不在测试任务状态组中',
        'failed_update_status'          => '平台更新状态信息失败',

    ),
);