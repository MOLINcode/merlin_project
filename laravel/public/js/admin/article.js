/**
 * Created by merlin on 15-12-23.
 */
define(function(require,exports,module){
    //引入T
    var T = require('T');


    $(document).delegate('.saveArticle','click',function(){


        $("#createArticle").ajaxSubmit({
            type:'post',
            url:'/admin/article/store',
            success:function(data){




            },
            error:function(XmlHttpRequest,textStatus,errorThrown){
                T.alert(lang_dataScene.upload_fail,'error');
                console.log(XmlHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })


    //导出的方法
    module.exports = {

    };
});
