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
        T.ajaxLoad(createUrl,'new_data_store',{'pid':0,'type':'zCreate'});
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
        var postData = {};
        postData.cate_id = '';
        postData.cate_name = $("input[name = 'cate_name']").val().trim();
        postData.as_name = $("input[name = 'as_name']").val().trim();
        postData.seo_key = $("input[name = 'seo_key']").val().trim();
        postData.seo_title = $("input[name = 'seo_title']").val().trim();
        postData.seo_desc = $("textarea[name = 'seo_desc']").html().trim();
        postData.pid = $("input[name = 'pid']").data('cate_pid');

        if($("input[name='cate_name']").data('cate_id')){
            postData.cate_id = $("input[name='cate_name']").data('cate_id');
            postData.pid = $("select[name = 'pid']").val();
        }

        T.restPost(createUrl,postData,function(data){
            if(data.code == 1000){
                $("#new_data_store").modal('hide');
                T.alert(data.msg,'success');
                getCateList({'page':1});
            }else{
                T.alert(data.msg,'error');
            }
        },function(data){
            T.alert(data.msg,'error');
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

//分类树新建编辑
    $(document).delegate('li .addCategory,.editCategory','click',function(){
        var cate_id = $(this).parent().data('cate_id');
        var type = $(this).data('type');
        var data = {'type':type,'cate_id':cate_id};
        var url = '/admin/category/create';
        if(type == 'edit'){
            url = '/admin/editCategory/'+cate_id;
        }
        T.ajaxLoad(url,'new_data_store',data,function(){});
        $("#new_data_store").modal();

    })

    //分类删除
    $(document).delegate('li .delCategory','click',function(){
        var cate_id = $(this).parent().data('cate_id');
        var delUrl = '/admin/delCategory/'+cate_id;
        T.Confirm('确定删除吗？',function(){
            T.restPost(delUrl,{'flag':1},function(data){
                getCateList({'page':1});
                T.alert(data.msg);
            })
        })

    })

    //导出的方法
    module.exports = {
        'getCateList': getCateList(data),
        'treeList':treeList,
    };
});
