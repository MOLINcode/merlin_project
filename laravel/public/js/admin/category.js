/**
 * Created by merlin on 15-12-1.
 */
define(function(require,exports,module){
    //引入T
    var T = require('T');
    var commonConf = require('commonConf');
    var data = {"page":1};



    $(document).delegate('.createTopType','click',function(){
        var createUrl = '/admin/category/create';
        T.ajaxLoad(createUrl,'new_data_store',{'pid':0});
        $("#new_data_store").modal();
    })




    var getCateList = function(data){

        var url = '/admin/ajaxCategoryList';

        T.ajaxLoad(url,'ajaxCategoryList',data,function(){})
    }
    getCateList(data);

    //导出的方法
    module.exports = {
        'getCateList': getCateList(data),
    };
});
