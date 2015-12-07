/**
 * Created by merlin on 15-12-1.
 */
define(function(require,exports,module){
    //引入T
    var T = require('T');
    var commonConf = require('commonConf');
    var data = {"page":1};
    var init = function(){
        $("#new_data_store").modal({
            remote:'/admin/category/create',
            show:false,
        });

        getCateList(data);
    }
/*
    $(document).delegate('.createTopCat','click',function(){
        var createUrl = '/admin/category/create';
        T.ajaxLoad('new_data_store',createUrl,{'pid':0});
    })*/


    var getCateList = function(data){

        var url = '/admin/ajaxCategoryList';

        T.ajaxLoad(url,'ajaxCategoryList',data,function(){})
    }

    //初始化方法
    init();
    //导出的方法
    module.exports = {
        'getCateList': getCateList(data),
    };
});
