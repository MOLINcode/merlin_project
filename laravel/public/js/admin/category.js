/**
 * Created by merlin on 15-12-1.
 */
define(function(require,exports,module){
    //引入T
    var T = require('T');
    var commonConf = require('commonConf');

    var init = function(){
        $(".fr.title-crumb").attr({'data-toggle':'modal','data-target':'#new_data_store'});
        $("#new_data_store").modal({
            remote:'/admin/category/create',
            show:false,
        });

        //弹窗事件清除数据
        $("#new_data_store").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
        var data = {"page":1};
        getCateList(data);
    }


    $(document).delegate('#saveCate','click',function(){
        var createUrl = '/admin/addCategory';
        var postData = $("#addCategory").serialize();
        console.log(postData);
        T.restPost(createUrl,postData,function(data){

        })

    })
    var getCateList = function(data){
        var url = '/admin/ajaxCategoryList';

        T.ajaxLoad(url,'ajaxCategoryList',data,function(){})
    }

    //初始化方法
    init();
    //导出的方法
    module.exports = {};
});
