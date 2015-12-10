/**
 * Created by bear on 14-8-28.
 */
var lang_common = (function () {
    return {
        'language': 'cn',
        'api': 'Api',
        'host': '主机',
        'site': '网站',
        'all': '全部',
        'no_data': '无数据',
        'china': '中国',
        'country': '国家',
        'province': '省份',
        'city': '城市',
        'high': '高',
        'low': '低',
        'last_time': '最近',
        'until': '截止到',
        'minutes': '分',
        'hours': '小时',
        'day': '天',
        'server_error': '服务器错误',
        'modify_success': '修改成功',
        'modify_faild': '修改失败',
        'times': '次',
        'save': '保存',
        'cancel': '取消'

    }
})();

var lang_app_topo = (function(){
    return {
        'install_smartagent_msg':'请先安装SmartAgent重试!',
        'show':'显示',
        'hide':'隐藏'
    }
})();

var lang_app = (function(){
    return {
        'slowest_truck'         : '最慢的事务',
        'is_loading'            : '正在加载',
        'normal'                : '正常',
        'slow'                  : '缓慢',
        'slowest'               : '非常慢',
        'avg_respon_time'       : '平均响应时间',
        'not_be_empty'          : '对不起，不能为空！',
        'should_be_num'         : '对不起，必须是数字！',
        'slowest_larg_slow'     : '对不起，非常慢时间应大于缓慢时间！',
        'percent'               : '百分比',
        'user_time_precent'     : '耗时占比',
        'method_use_time'       : '方法耗时变化曲线',
        'save_success'          :'保存成功',
        'avg'                   :'平均响应时间',
        'request_num'           :'访问次数',
        'throughput'            :'吞吐量',
        'slowest_method'        :'最慢元素',
        'setting_number_alert_message' :'请输入数字！',
        'setting_time_alert_message' :'缓慢的响应时长应该小于非常缓慢的时长！',
        'setting_error_alert_message' :'错误比率不可超过100%'
    }
})();


var lang_browser = (function(){
    return {
        'respon_time'           : '响应时间',
        'through_rate'          : '吞吐率',
        'response_time_trend'   : '浏览器响应时间趋势',
        'through_rate_trend'    : '浏览器吞吐率趋势',
        'js_error_num'          : '浏览器JS错误数',
        'ajax_request_num'      : '浏览器AJAX请求数',
        'used_ratio'            : '浏览器使用比例',
        'wx_response_time_trend': '微信版本响应时间趋势',
        'wx_through_rate_trend' : '微信版本吞吐率趋势',
        'wx_js_error_num'       : '微信版本JS错误数',
        'wx_ajax_request_num'   : '微信版本AJAX请求数',
        'wx_used_ratio'         : '微信版本使用比例',
        'browser'               : '浏览器',
        'wexin_version'         : '微信版本',
        'search_by_browser'     : '按浏览器搜索',
        'search_by_weixin'      : '按微信版本搜索',
        'search_by_country'     : '按国家搜索',
        'search_by_city'        : '按城市搜索',
        'search_by_pro'         : '按省份搜索',
        'show_all_page'         : '显示所有页面'

    }
})();

var lang_system = (function () {
    return{
        'sure_delete_depart'    :'确认删除本部门？',
        'input_email'           :'请输入邮箱',
        'choose_group'          :'请选择部门',
        'choose_role'           :'请选择角色',
        'modify_user_success'   :'修改用户成功！',
        'modify_user_failure'   :'修改用户失败！',
        'modify_success'        :'操作成功！'
    }
})();

var lang_host = (function(){
    return {
        'used_space'            :'已使用空间',
        'total_space'           :'总空间',
        'flow_in_avg'           :'平均流入',
        'flow_out_avg'          :'平均流出',
        'open'                  : '已开启',
        'open_notice'           : '已开启',
        'close'                 : '已暂停',
        'close_notice'          : '已暂停',
        'success'               : '处理成功！',
        'failed'                : '处理失败',
        'service_on'            :'开启服务',
        'service_ff'            :'关闭服务',
        'disk_use_rate'         :'磁盘使用率',
        'surplus_space'         :'剩余空间',
        'used'                  :'已使用',
        'average_inflow'        :'平均流入',
        'average_outflow'        :'平均流出'

    }
})();

var lang_alert_page = (function () {
    return {
        'alert': '告警',
        'alert_level': '告警等级',
        'warning': '警告',
        'error': '故障',
        'recover': '恢复',
        'response_time': '响应时间',
        'checked_result': '检测结果',
        'response_status': '响应状态',
        'alert_notice': '告警通知',
        'snapshot': '查看快照',
        'monitor_type': '监控类型',
        'nearly': '最近',
        'statistics': '统计',
        'amount': '总数',
        'respectively': '其中',
        'created_time': '产生时间',
        'nearly_alert_time': '最近告警时间',
        'persist': '持续',
        'load_more': '加载更多',
        'loaded_up': '已加载完成',
        'alert_interval': '告警间隔频率',
        'connected': '已关联',
        'unconnected': '未关联',
        'add_template': '请添加模板名称',
        'success': '处理成功！',
        'alert_frequency_invalid': '告警频率不能为空！',
        'failed': '处理失败',
        'create_alert_template_first': '请先创建告警模板',
        'add_alert_item': '请添加告警规则',
        'add_template_name': '请输入模板名称',
        'confirm_to_remove': '确认是否删除该模版',
        'add_alert_group': '请添加报警组',
        'minute': '分钟',
        'del_alert_template_notice': '修改状态，不可删除',
        'confirm': '确定',
        'cancel': '取消',
        'sure_to_delete': '你确定要删除?',
        'add_alert_channel':'请添加告警组',
        'add_alert_member':'请添加部门或成员'
    }
})();

var lang_ucenter = (function(){
    return{
        'get_check_code'        :'获取验证码',
        'send_success'          :'发送成功',
        'email_not_be_empty'    :'邮箱不能为空',
        'check_emial_notice'    :'邮箱格式有误，请您检查后重新输入',
        'check_code_is_send'    :'验证码已成功发送到您的邮箱，请您在24小时内完成验证。',
        'input_check_code'      :'请输入验证码',
        'please_get_check_code' :'请获取验证码',
        'error_phone_num'       :'错误的手机号码',
        'please_get_msg_cde'    :'获取短信验证码',
        'get_once'              :'重新获取',
        'error_code'            :'验证码错误',
        'error_code_get_once'   :'验证码发送失败，请重获取。',
        'code_success_notice'   :'验证码发送成功，请注意查收短信,没有收到，您可以在60秒后要求系统重新发送。',
        'quit_alert'            :'确定要退出吗？'
    }
})();

var lang_mobile = (function () {
    return {
        'check': '查看',
        'china': '中国',
        'resp_time': '响应时间',
        'throughput_rate': '吞吐率',
        'reqeust_error_rate': '请求错误率',
        'world': '世界',
        'country': '国家',
        'province': '省份',
        'city': '城市',
        'search_by_country': '按国家搜索',
        'search_by_city': '按城市搜索',
        'search_by_province': '按省份搜索',
        'edit_process': '修改流程',
        'add_process': '添加流程',
        'new_user':'新增用户',
        'active_user':'活跃用户',
        'http_error_rate':'HTTP错误率',
        'network_error_rate':'网络失败率',
        'thread_rate':'发生崩溃率',
        'all'        :'全部',
        'modify_success':'修改成功',
        'del_success'        :'删除成功',
        'del_failed'         :'删除失败',
        'sure_to_del'         :'是否确认要删除该行为流程',
        'enter_process_name'  :'请输入流程名称！',
        'no_any_cation'       :'没有添加任何行为！',
        'process_too_long'   :'行为流程长度过长！',
        'high':'高',
        'low':'低',
        'no_sim_card':'未插SIM卡',
        'fixed':'已修复',
        'unfixed':'未修复',
        'cancel_fixed':'取消修复?',
        'confirm_fixed':'修复?',
        'no_permission':'您没有权限'
    }
})();

var lang_time = (function(){
    return {
        'thirty_minutes':'30分钟',
        'one_hour':'1小时',
        'six_hours':'6小时',
        'twelve_hours':'12小时',
        'one_day':'1天',
        'seven_days':'7天',
        'thirty_days':'30天',
        'nearly':'最近',
        'from':'截止到',
        'format':{
            1:"30分钟",
            2:"1小时",
            3:"6小时",
            4:"12小时",
            5:"1天",
            6:"7天"
        }
    }
})();
var lang_plugin = (function(){
    return {
        'action_success'                    :'操作成功',
        'action_error'                      :'操作失败',
        'create_service_success'            :'创建成功',
        'save_success'                      :'保存成功',
        'db_name'                           :'数据库名称',
        'port'                              :'端口',
        'user_name'                         :'用户名',
        'user_pass'                         :'密码',
        'delete_db_conf'                    :'删除DB配置'


    }
})();
var lang_tsb = (function(){
    return {
        'not_found'                         :'哎呀，啥都没有发现，怎么回事?',
        'any_question'                      :'如果有任何问题',
        'get_help'                          :'请查看帮助',
        'get_phone'                         :'或联系我们'
    }
})();

var lang_echars = (function(){
    return {
        'click_save'                        : '点击保存',
        'save_as'                           : '保存为图片',
        'recovery'                          : '还原',
        'funnel_plot'                       : '漏斗图切换',
        'pie_chart'                         : '饼图切换',
        'chord_diagram'                     : '和弦图切换',
        'force_directed_layout'             : '力导向布局图切换',
        'tile'                              : '平铺',
        'accumulation'                      : '堆积',
        'column_chart'                      : '柱形图切换',
        'line_chart'                        : '折线图切换',
        'data_view'                         : '数据视图',
        'close'                             : '关闭',
        'refresh'                           : '刷新',
        'region_scaling_back'               : '区域缩放后退',
        'area_scaling'                      : '区域缩放',
        'auxiliary_line_switch'             : '辅助线开关',
        'delete_auxiliary_line'             : '删除辅助线',
        'clean_auxiliary_line'              : '清空辅助线'
    }
})();

var lang_code_message = (function(){
    return {
        '1406'                        : '密码必须为大于6位的数字或字符',
        '1405'                        : '密码不能为空',
        '1403'                        : '邮箱不正确',
        '1408'                        : '两次输入的密码不同',
        '900'                         : '邮箱已经存在'
    }
})();

var lang_chart_tip = (function(){
    return {
        'time':'时间',
        'avg':'平均值',
        'max':'最大值',
        'min':'最小值',
        'count':'次数',
        'memory':'内存',
        'item':'指标',
        'view':'视图',
        'request':'请求',
        'start_time':'开始时间',
        'time_range':'持续时间',
        'request_count':'请求数'
    };
})();
var lang_app_create = (function(){
    return {
        'app_create_linux_vedio':'Linux 版 Smart Agent 安装视频',
        'app_create_windows_vedio':'Windows 版 Smart Agent 安装视频'
    };
})();

var lang_sdk_user = (function(){
    return {
        'id':'用户id',
        'name':'用户名',
        'email':'邮箱',
        'phone':'电话'
    };
})();