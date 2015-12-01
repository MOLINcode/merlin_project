@extends('layouts.ajax_master')
@section('app_css')
    {{App\ViewSpall\ResourceSpall::includeCSS('category')}}
@endsection
@section('content')
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title " id="new_data_store_myModalLabel">  创建 分类</h4>
            </div>
            <form class="form-horizontal" id="addCategory" method="post"  onsubmit="return false">
                <div class="modal-body">
                    <p class="explain">如果创建顶级分类则直接创建,或者选择指定分类下创建分类</p>

                    <div class="form-group">
                        <label for="name_data_store" class="col-sm-3 control-label">上级分类</label>
                        <div class="col-sm-9">
                            <select name="" id="" class="form-control col-sm-9">
                                <option>固定分类</option>
                                <option>分类1</option>
                                <option>分类2</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">分类名称</label>
                        <div class="col-sm-7">
                           <input type="text" class="form-control" id="up_file" placeholder="名称">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">分类别称</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="up_file" placeholder="名称">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">SEO关键字</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="up_file" placeholder="关键字">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">SEO标题</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="up_file" placeholder="标题">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">SEO描述</label>
                        <div class="col-sm-7">
                            <textarea name="" id="" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-noicon btn-green dataSave">保存</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('app_js')
    <script>
        seajs.use(['T'],function(T){

        });
    </script>
@endsection