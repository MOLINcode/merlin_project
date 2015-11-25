/**
 * Created by admin-chen on 15-7-18.
 */
define(function(require,exports,moudle){
    //引入公共配置
    var commonConf = require('commonConf');
    //引入T
    var T = require('T');

    //提交用户数据
    $(document).delegate(".registerDispose",'click',function(){
        var registerData = $('#registerId').serialize();
        T.restPost(commonConf.uriSet.ajax_disposeRegister,registerData,function(data){
            if(data.code == 1000){
                //T.alert('注册成功！','success');
                var umail= $('input[name=user_email]').val();
                window.location.href='/registerSuccess?mail='+umail;
            }

        },function(data){
            T.alert(data.msg,'error');

        });
    })


});