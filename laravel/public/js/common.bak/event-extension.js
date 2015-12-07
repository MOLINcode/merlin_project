/**
 * Created by vision on 15-4-12.
 */
define(function (require, exports, module) {

    var $ = jQuery = require('jquery');
    var T = require('T');



    /**
     * 排序事件
     * 触发：orderby按钮点击时
     * 绑定元素： table
     */
    $(document).delegate('table th[data-item]:has(i.fa-sort)','click',function(){
        var $th = $(this);
        var $i = $th.find('i.fa-sort');
        var $table = $i.parents('table');
        var order = $th.data('item');
        var sort = $i.hasClass('fa-sort-desc') ? 'asc' : 'desc';


        $table.data('order',order).data('sort',sort);
        $table.trigger('orderby',{element:$(this),icon:$i,sort:sort,orderby:order});
        //恢复同类样式
        $table.find('th i.fa-sort-desc,th i.fa-sort-asc').removeClass('fa-sort-desc').removeClass('fa-sort-asc');
        //添加样式
        $i.addClass('fa-sort-'+sort);
    });

	/**
	 * 添加默认排序
	 */
	$('table:has(i.fa-sort-desc,i.fa-sort-asc)').each(function(){
		if($(this).find('i.fa-sort-desc')){
			$(this).data('order',$(this).find('th:has(i.fa-sort-desc)').data("item"));
			$(this).data('sort',"desc");
		}else if($(this).find('i.fa-sort-asc')){
			$(this).data('order',$(this).find('th:has(i.fa-sort-asc)').data("item"));
			$(this).data('sort',"asc");
		}
	});
    /**
     * 键盘按下事件
     * 触发：键盘按下时
     * 绑定元素：this
     */
    $('[data-onkey]').keypress(function(event){
        var keyCode = $(this).data('onkey');

        if(keyCode){
            if(event.keyCode == keyCode){
                $(this).trigger('onkey',keyCode);
            }
        }else{
            $(this).trigger('onkey',keyCode);
        }

    });
    /**
     * 绑定搜索图标点击事件
     */
    $('.filter_search .fa-search').click(function(){
        $(this).parents('.filter_search').find('input[data-onkey]').trigger('onkey',13);
    });


    /**
     * 复选框筛选过滤事件
     * 触发：筛选复选框
     */
    $('input[data-oncheck]:checkbox').change(function(){
        var checked = $(this).prop('checked');
        var type = $(this).data('oncheck');
        var target = $(this).data('target');

        var $items = $('[data-item="'+target+'"]');

        var ok = $(this).trigger('oncheck',{checked:checked,oncheck:type,target:target,items:$items});
        if(ok){
            if(type == 'itemshow'){
                checked ? $items.show() : $items.hide();
            }else{
                checked ? $items.hide() : $items.show();
            }
        }

    });

    /**
     * 隐藏&关闭事件
     */
    $('[data-hide]').click(function(){
        var target = $(this).data('hide');
        $(target).hide();
    });
    $('[data-show]').click(function(){
        var target = $(this).data('show');
        $(target).show();
    });

    /**
     *  列表弹窗事件
     *  触发：列表td>a被点击时
     *  绑定元素： table
     */
    $(document).delegate('table[data-toggle="modal"]>tbody>tr>td>a[data-toggle="modal"]','click',function(){
        var $table = $(this).parents('table');
        var option = {
            data : $.extend($table.data(),$(this).data()),
            target  : 'pop_modal',
            url: $table.data('url'),
            title:'加载中...',
            element:$(this),
            html:'',
            modal:'modal'

        }
        option.html =  '<div class="modal-dialog popup">' +
            '<div class="modal-title">'       +
            ' <button type="button" class="close" data-dismiss="modal"></button>' +
            '<div class="modal-title">' +   option.title + '</div>' +
            '<div class="loading"></div>' +
            '</div></div>';

        $table.trigger('modal',option);
        delete option.data.toggle;
        if(option.url && option.target){
            if(option.modal){
                $('#'+option.target).html(option.html).modal();
            }

            T.ajaxLoad(option.url,option.target,option.data)
        }

    });

    $(document).delegate('.btn-group .btn','click',function(){
        $(this).addClass('active').siblings().removeClass('active');
        $(this).parents('.btn-group').trigger('btnchange',$(this));
    });




});