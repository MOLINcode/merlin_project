@extends('layouts.ajax_master')

@section('content')

    @if(!$listData)
    <div class="sad">
        <div class="sad-img">
            <img src="{{asset('/img/sad.png')}}">
        </div>
        <div class="sad-font">
            <p>没有类</p>
        </div>
    </div>
    @else
        <div class="tree well">
            {{treeList($listData)}}
        </div>
    @endif


@endsection

@section('app_js')
    <script>
        seajs.use(['T'],function(T){
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
        })
    </script>
@endsection

