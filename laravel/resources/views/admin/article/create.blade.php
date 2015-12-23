@extends('layouts.master')
@section('app_css')
    {{App\ViewSpall\ResourceSpall::includeCSS('article')}}
@endsection
@section('app_js')
    {{App\ViewSpall\ResourceSpall::includeJS('ueditor')}}
    <script>
        seajs.use('article');
    </script>
@endsection
@section('content')
    <div class="main">
        <div class="main-title clearfix">
            <ol class="fl breadcrumb data-store">
                <li><a href="javascript:;">后台管理</a></li>
                <li><a href="javascript:;">文章管理</a></li>
                <li><a href="javascript:;">创建文章</a></li>
            </ol>
        </div>
        <div class="main-status">
            <div class="inner">

                <!--基本信息-->
                <div class="ev_set">
                    <p>基本信息</p>
                    <div class="content">
                        <div class="form-horizontal">
                            <div class="clearfix">
                                <label for="test_name" class="control-label">文章名称</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="article_name" placeholder="文章名称">
                                </div>
                            </div>

                            <div class="clearfix">
                                <label for="test_name" class="control-label">所属分类</label>
                                <div class="col-sm-4">
                                    <select name="cate_id" id="" class="form-control">
                                        @foreach($all_cate as $key =>$val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="clearfix">
                                <label for="test_name" class="control-label">所属标签</label>
                                <div class="col-sm-4">
                                    <ul class="ul-gray-alert clearfix alert_group_select list-unstyled">
                                        <li data-alert_group_id="40" class="select_group_item"><a href="#">aaa</a><i class="fa fa-times"></i></li>
                                        <li data-alert_group_id="38" class="select_group_item"><a href="#">bear</a><i class="fa fa-times"></i></li>
                                        <li class="group_select">
                                            <div class="btn-group" role="group">
                                                <a type="button" class="dropdown-toggle cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-plus"></i>添加                                    </a>
                                                <ul class="dropdown-menu group_data list-unstyled">
                                                    <li data-alert_group_id="39" class="group_item"><a href="#">test</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--图片封面-->
                <div class="ev_set">
                    <p>图片封面</p>
                    <div class="content">
                        <div class="form-horizontal">

                            <div class="clearfix">
                                <div class="col-sm-3 col-sm-offset-1">
                                    <input type="file" class="form-control" name="data_file_name" id="choice_file" onchange="up_file.value=this.value" style="display:none;">
                                    <input type="text" class="form-control" id="up_file" placeholder="选择图片文件">
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn-white" onClick="choice_file.click();">上传图片</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--内容-->
                <div class="ev_set">
                    <p>文章内容</p>
                    <div class="content">
                        <div class="form-horizontal">

                            <div class="clearfix editor">
                                <div class="col-sm-10 col-sm-offset-1" >
                                    <textarea name="content" id="myEditor" rows="10" class='form-control'></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>

@endsection
