/**
 * Created by merlin on 15-12-23.
 */
define(function(require,exports,module){
    //引入T
    var T = require('T');

    //标签特效
    $(document).delegate('.group_data .group_item','click',function(){
        var dom = $(this);
        //var length = $('.group_data .group_item');
        dom.append('<i class="fa fa-times"></i>').removeClass('group_item').addClass('select_group_item');
        $('.group_select').before(dom);
    })

    $(document).delegate('.select_group_item .fa-times','click',function(){
        var dom = $(this).parent();
        dom.removeClass('select_group_item').addClass('group_item').find('.fa-times').remove();
        $('.group_data').append(dom);
    })
    $(document).delegate('.group_select .addTag','click',function(){
        $("ul.group_data").toggleClass('display-block')
    })

    //保存
    $(document).delegate('.saveArticle','click',function(){
        var data ={};
        data.article_name = $("input[name='article_name']").val().trim();
        data.cate_id = $("select[name='cate_id']").val();
        var tags = [];
        $(".alert_group_select .select_group_item").each(function(){
            tags.push($(this).data('tag_id'));
        })
        data.tags = tags;
        data.picture = $("input[name='file']");
        data.content = $("#myEditor").html().trim();
        console.log(data);
        T.restPost('/article/store',data,function(){

        })
    })





    //导出的方法
    module.exports = {

        'upload_image':upload_image,

    };
});
