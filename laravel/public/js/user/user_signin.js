/**
 * Created by admin-chen on 15-6-23.
 */
define(function(require,exports,module){
    var commonConf = require('commonConf');
    var T = require('T');

    $(document).keypress(function(e) {
        // 回车键事件
        if(e.which == 13) {
            $("#submitLogin").click();
        }
    });

    var user_login = function () {
        var postData = $('#__login_form').serialize();
        var url = commonConf.uriSet.ajax_disposeSignIn;
        T.restPost(url, postData, function (back) {
            //window.location = '/';
        }, function (back) {
            if (back.data.filed) {
                $('#__login_form input[name=' + back.data.filed + ']')
                    .attr('placeholder', back.msg)
                    .css({'border': '1px solid #a94442'})
                    .parent('div').addClass('has-error');

            } else {
                T.alert(back.msg,'error');
            }
            return false;
        });
    }

    $('#submitLogin').click(function(){
        if($(this).attr('disable') == 'disable'){
            return false;
        }
        $(this).attr('disable','disable');

        user_login();
        setTimeout(function(){
            $('#submitLogin').removeAttr('disable');
        },2000)
    });
});