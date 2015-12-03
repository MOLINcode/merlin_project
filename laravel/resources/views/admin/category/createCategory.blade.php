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
                        <label for="name_data_store" class="col-sm-3 control-label">父级分类</label>
                        <div class="col-sm-7">
                            <input type="text" name="pid" value="" class="form-control" placeholder="名称">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">分类名称</label>
                        <div class="col-sm-7">
                           <input type="text" name="cate_name" value="{{$cateInfo->cate_name}}" class="form-control" placeholder="名称">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">分类别称</label>
                        <div class="col-sm-7">
                            <input type="text" name="as_name" value="{{$cateInfo->as_name}}" class="form-control" placeholder="名称">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">SEO关键字</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" value="{{$cateInfo->seo_key}}" name="seo_key" placeholder="关键字">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">SEO标题</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" value="{{$cateInfo->seo_title}}"  name="seo_title" placeholder="标题">
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label for="choice_file" class="col-sm-3 control-label">SEO描述</label>
                        <div class="col-sm-7">
                            <textarea id="" class="form-control" name="seo_desc" rows="5">
                                {{$cateInfo->seo_desc}}
                            </textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" id="saveCate" class="btn btn-noicon btn-green">保存</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('app_js')
    <script>
        seajs.use(['category','T'],function(category,T){
            $(document).delegate('#saveCate','click',function(){
                var createUrl = '/admin/addCategory';
                var postData = $("#addCategory").serialize();
                console.log(postData);
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
        });
    </script>
@endsection

