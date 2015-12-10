/**
 * Created by bear on 14-8-28.
 */
var lang_common = (function(){
    return {
        'language':'cn',
        'api':'Api',
        'host':'主机',
        'site':'网站',
        'all':'全部',
        'no_data' : '无数据',
        'china':'中国',
        'country':'国家',
        'province':'省份',
        'city':'城市',
        'high':'高',
        'low' : '低',
        'last_time' :'最近',
        'until' : '截止到',
        'minutes' : '分',
        'hours' : '小时',
        'day':'天',
        'server_error':'服务器错误',
        'modify_success':'修改成功',
        'modify_faild':'修改失败'

    }
})();
var lang_host = (function(){
    return {
        'used_space':'已使用空间',
        'total_space':'总空间',
        'flow_in_avg':'平均流入',
        'flow_out_avg':'平均流出'

    }
})();

var lang_alert_page = (function(){
    return {
        'alert':'告警',
        'alert_level':'告警等级',
        'warning':'警告',
        'error':'故障',
        'recover':'恢复',
        'response_time':'响应时间',
        'checked_result':'检测结果',
        'response_status':'响应状态',
        'alert_notice':'告警通知',
        'snapshot':'查看快照',
        'monitor_type':'监控类型',
        'nearly':'最近',
        'statistics':'统计',
        'amount':'总数',
        'respectively':'其中',
        'created_time':'产生时间',
        'nearly_alert_time':'最近告警时间',
        'persist':'持续',
        'load_more':'加载更多',
        'loaded_up':'已加载完成'
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
        'from':'截止到'
    }
})();

//数据仓库
var lang_data_store = (function(){
    return{
        'upload_failed':'上传失败'
    }
})();

//系统设置
var lang_system = (function(){
    return{
        //注册验证
        'company_name_validate':'　*公司名称必须填写',
        'company_url_validate':'　*公司域名必须填写',
        'username_validate':'　*用户名称必须填写',
        'email_validate':'　*邮箱必须填写',
        'email_validate1':'　*邮箱格式不正确',
        'email_validate2':'　*该邮箱已经被注册',
        'mobile_validate':'　*手机号必须填写',
        'mobile_validate1':'　*请填写正确的手机号',
        'mobile_validate2':'　*该手机号已经被注册',
        //用户中心
        'new_email_empty':'邮箱不能为空',
        'new_email_error':'邮箱格式有误，请您检查后重新输入',
        'send_code':'验证码已成功发送到您的邮箱，请您在24小时内完成验证。',
        'input_code':'请输入验证码',
        'get_code':'请获取验证码',
        //邀请用户
        'username_empty':'请填写用户名称',
        'email_empty':'请填写邮箱',
        //用户提权
        'handle_success':'权限修改成功',
        'handle_failed':'权限修改失败',
        'resend_email':'发送成功，请登陆邮箱完成激活！',
        //修改组织信息
        'modify_success':'修改成功'

    }
})();
//测试模板
lang_taskTpl = (function(){
    return {
        'advance_booking' : '请提前30分钟预约！',
    }
})
//测试任务
var lang_testCase = (function(){
    return{
        //创建
        'default_zero':'默认时间是从零点开始，请不要重复设置零点！',
        'input_number':'请输入数字！',
        'over_hundred':'不能超过百分百！',
        'time_increment':'时间要按顺序递增！',
        'press':'压力',
        //预约
        'appoint_success':'预约成功',
        'appoint_fail':'预约失败',

    }
})();

//测试场景
var lang_dataScene = (function(){
    return{
        'upload_fail':'上传失败'
    }
})();
