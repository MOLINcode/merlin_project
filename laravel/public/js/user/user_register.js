/**
 * Created by admin-chen on 15-7-18.
 */
define(function(require,exports,moudle){
    //引入公共配置
    var commonConf = require('commonConf');
    //jQuery 表单验证插件
    require('jqueryValidate')($);
    require('jqueryValidateAddMethod')($);

    //引入T
    var T = require('T');

    //验证用户数据
    $('#registerId').validate({
        rules:{
            company_name:'required',
            company_url:'required',
            user_name:'required',
            user_email:{
                required:true,
                email:true,
                remote: {
                    url: "/ajaxCheckRegisterData",     //后台处理程序
                    type: "post",               //数据发送方式
                    dataType: "json",           //接受数据格式
                    data: {                     //要传递的数据
                        user_email: function() {
                            return $("#registerId").find('[name="user_email"]').val();
                        }
                    }
                }
            },
            user_mobile:{
                required:true,
                //mobileUK:true,
                remote: {
                    url: "/ajaxCheckRegisterData",     //后台处理程序
                    type: "post",               //数据发送方式
                    dataType: "json",           //接受数据格式
                    data: {                     //要传递的数据
                        user_email: function() {
                            return $("#registerId").find('[name="user_mobile"]').val();
                        }
                    }
                }
            }
        },
        messages:{
            company_name:lang_system.company_name_validate,
            company_url:lang_system.company_url_validate,
            user_name:lang_system.username_validate,
            user_email:{
                required:lang_system.email_validate,
                email:lang_system.email_validate1,
                remote:lang_system.email_validate2
            },
            user_mobile:{
                required:lang_system.mobile_validate,
                mobileUK:lang_system.mobile_validate1,
                remote:lang_system.mobile_validate2
            }
        },

        //自定义显示的错误样式
        errorClass:'cloud_error',

        submitHandler: function(form)
        {
            var registerData = $(form).serialize();
            T.restPost(commonConf.uriSet.ajax_disposeRegister,registerData,function(data){
                if(data.code == 1000){
                    //T.alert('注册成功！','success');
                    var umail= $('input[name=user_email]').val();
                    window.location.href='/signUpSuccess?mail='+umail;
                }
            },function(data){
                T.alert(data.msg,'error');
            });
        }
    });
});