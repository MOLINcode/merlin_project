/**
 * Created by neeke on 14-5-15.
 */
define(function(require,exports,moudle){

    var uriSet = {
        ajax_disposeSignIn:'/disposeSignIn',
        ajax_disposeRegister:'/disposeRegister',

        //负载测试相关的url
        testCase_ajaxGetSearchList:'/testCase/ajaxGetSearchList',

        //数据仓库相关的路由
        dataStore_ajaxGetList: '/dataStore/ajaxGetList',
        dataStore_delete:'/dataStore/delete',

        //测试场景
        testScene_ajaxGetList: '/testScene/ajaxGetList',
        testScene_delete:'/testScene/delete',
        testScene_ajaxCreate:'/testScene/doCreate',
        testScene_edit:'/testScene/create',

        //测试模板
        taskTpl_ajaxList:'/taskTpl/ajaxGetList',
        taskTpl_delete:'/taskTpl/delete/',
        taskTpl_appoint:'/taskTpl/appoint/',
        taskTpl_disposeCreate:'/taskTpl/disposeCreate',
        taskTpl_ajaxLoadTestScene:'/taskTpl/ajaxLoadTestSceneList',
        taskTpl_ajaxLoadTestData:'/taskTpl/ajaxLoadTestDataList',
    };

    var app_setting = {
            /****** admin ******/
            'ajax_load_register_user': '/ajax/get_register_user',
            'ajax_dispose_register': '/ajax/dispose_register',
            'ajax_active_email_resend':'/ajax/active_email_resend',

            /***** group ******/
            'ajax_load_groups': '/ajax/get_groups',
            'ajax_create_group': '/ajax/group/create',
            'ajax_modify_group': '/ajax/group/modify',
            'ajax_load_group_users': '/ajax/get_group_users',
            'ajax_add_user': '/ajax/user/create',
            'ajax_modify_user_status': '/ajax/user/modify_status',
            'ajax_modify_user_group': '/ajax/user/modify_group',
            'ajax_add_site_user': '/ajax/site/add_user',//
            'ajax_remove_team_user': '/site/team/remove',//
            'ajax_modify_team_user': '/site/user/modify',//
            'ajax_modify_alert_status': '/ajax/site/alert/status',
            'ajax_get_group_user': '/ajax/site/group/user',
            'ajax_modify_size_status': '/ajax/site/size/status',
            'ajax_load_team_users': '/ajax/load_team_users',

            /****** user center ******/
            'ajax_user_login': '/signin',
           // 'ajax_load_modify_email': '/ajax/user/new_email',
            'ajax_send_email_code': '/ajax/user/email_code',
            'ajax_check_email_code': '/ajax/user/check_code',
            'ajax_modify_user_email': '/ajax/user/modify_email',
            'ajax_load_user_info': '/ajax/user/user_info',
            'ajax_modify_user_info': '/ajax/user/modify_info',
            'ajax_modify_user_pass': '/ajax/user/modify_pass',
            'ajax_load_user_like': '/ajax/user/user_like',
            'ajax_modify_user_like': '/ajax/user/modify_like',
            'ajax_load_sms_setting': '/ajax/user/sms_setting',
            'ajax_modify_sms_setting': '/ajax/user/modify_sms_setting',
            'ajax_load_email_setting': '/ajax/user/email_setting',
            'ajax_modify_email_setting': '/ajax/user/modify_email_setting',
        };


    moudle.exports = {
        uriSet:uriSet,
        app_setting:app_setting
    }

});

//用户中心枚举
var ucenter_setting = (function () {

    return {
        'email_code_time_out' : 120      //用户中心修改邮箱时，验证码过期时间
    }

})();

