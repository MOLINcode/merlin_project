@extends('layouts.master')
@section('app_css')
{{App\ViewSpall\ResourceSpall::includeCSS('category')}}
@endsection
@section('content')
    <div class="main">
        <div class="main-title clearfix">
            <ol class="fl breadcrumb data-store">
                <li><a href="javascript:;">后台管理</a></li>
                <li><a href="javascript:;">分类管理</a></li>
            </ol>
            <div class="fr title-crumb">
                <a class="btn btn-icon btn-orange" href="/admin/category/create "><img src="{{asset('/img/plus.png')}}">创建分类</a>
            </div>
        </div>
        <div class="main-status">
            <ul class="nav nav-pills" role="tablist">
                <li>分类</li>
                <li role="presentation" class="active">
                    <a href="#all-store-tab" aria-controls="all-store-tab" role="tab" data-toggle="tab" id="countall">所有&nbsp;(<span>5</span>)</a>
                </li>
                <li class="pull-right">
                    <div class="filter_tag">
                        <div class="filter_search">
                            <input type="text" placeholder="按数据名称搜索" id="searchName" name="searchName">
                            <span class="fa fa-search" id="searchDataBtn"></span>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="all-store-tab">
                    <div class="table-responsive main-table" id="dataStoreListId">
                        <div class="loading" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- 创建测试场景弹出框 -->
    <div class="modal size" id="new_data_store" tabindex="-1" role="dialog" aria-labelledby="new_data_store_myModalLabel">

    </div>
@endsection
@section('app_js')
    <script>
        seajs.use('category');
    </script>
@endsection

