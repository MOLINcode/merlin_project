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

    //保存分类
    $(document).undelegate('#saveCate','click').delegate('#saveCate','click',function(){
        var createUrl = '/admin/addCategory';
        var postData = $("#addCategory").serialize();
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

    //分类树
    var treeList = function () {
        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', '关闭节点');
        $('.tree ul li:not(.parent_li)').find(' > span > i ').addClass('fa-leaf').removeClass('fa-folder-open');
        $('.tree li a').attr('title', '修改分类');
        $('.tree li a').on('click',function () {
            alert('Node:'+$(this).attr('id')+'父节点：'+$(this).parent().parent().parent('ul>a'));
        });
        $('.tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).attr('title', '展开节点').find(' > i').addClass('fa-plus-square').removeClass('fa-minus-square');
            } else {
                children.show('fast');
                $(this).attr('title', '关闭节点').find(' > i').addClass('fa-minus-square').removeClass('fa-plus-square');
            }
            e.stopPropagation();
        });
    }
    treeList();

//分类树新建编辑
    $(document).delegate('li .addCategory,.editCategory','click',function(){
        $("#new_data_store").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        }).modal();
        var cate_id = $(this).parent().data('cate_id');
        var type = $(this).data('type');
        var p_name = $(this).closest('.parentCat').html();
        var data = {'p_name':p_name,'type':type}
        var url = '/admin/category/create';
        if(type == 'edit'){
            url = '/admin/editCategory/'+cate_id;
        }

        T.ajaxLoad(url,'new_data_store',data,function(){

        });

    })

    //导出的方法
    module.exports = {
        'getCateList': getCateList(data),
    };
});
