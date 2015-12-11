/**
 * Created by merlin on 15-12-1.
 */
define(function(require,exports,module){
    //引入T
    var T = require('T');
    var commonConf = require('commonConf');
    var data = {"page":1};

    //新建顶级分类
    $(document).delegate('.createTopType','click',function(){
        var createUrl = '/admin/category/zCreate';
        T.ajaxLoad(createUrl,'new_data_store',{'pid':0});
        $("#new_data_store").modal();
    })

    //分类树新建编辑
    $(document).delegate('li .addCategory,.editCategory','click',function(){
        var cate_id = $(this).parent().data('cate_id');
        var type = $(this).data('type');
        var data = {};
        var url = '';
        switch (type)
        {
            case 'create':
                url = '/admin/category/create/'+cate_id;
                data = {'type':type}
                break;
            case 'edit':
                url = '/admin/category/edit/'+cate_id;
                data = {'type':type}
        }


        T.ajaxLoad(url,'new_data_store',data,function(){

        });

    })




    var getCateList = function(data){

        var url = '/admin/ajaxCategoryList';
        T.ajaxLoad(url,'ajaxCategoryList',data,function(){})
    }
    getCateList(data);

    //保存分类
    $(document).undelegate('#saveCate','click').delegate('#saveCate','click',function(){
        var createUrl = '/admin/addCategory';
        var postData = {};
        postData.pid = $("input[name='pid']").data('pid');
        postData.cate_name = $("input[name='cate_name']").val().trim();
        postData.as_name = $("input[name='as_name']").val().trim();
        postData.seo_key = $("input[name='seo_key']").val().trim();
        postData.seo_title = $("input[name='seo_title']").val().trim();
        postData.seo_desc = $("input[name='seo_desc']").val().trim();
        T.restPost(createUrl,postData,function(data){
            if(data.code == 1000){
                $("#new_data_store").modal('hide');
                T.alert(data.msg,'success');
                category.getCateList({'page':1});
            }else{
                T.alert(data.msg,'error');
            }
        })

    })




    //导出的方法
    module.exports = {
        'getCateList': getCateList(data),
    };
});
