@extends('layouts.master')
@section('app_css')
    {{App\ViewSpall\ResourceSpall::includeCSS('article')}}
    {{App\ViewSpall\ResourceSpall::includeCSS('upload_image')}}
@endsection
@section('app_js')
    <script>
        seajs.use(['iUploader','article']);
    </script>
    {{App\ViewSpall\ResourceSpall::includeJS('upload_image')}}
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

                <div class="ev_set">
                    <p>图片封面</p>
                    <div class="content">
                        <div class="form-horizontal">

                            <div class="clearfix">
                                <div class="col-sm-11 col-sm-offset-1">
                                    {{--<div id="MyUploader">--}}
                                    {{--</div>--}}
                                    <div id="wrapper">
                                        <div id="container">
                                            <!--头部，相册选择和格式选择-->

                                            <div id="uploader">
                                                <div class="queueList">
                                                    <div id="dndArea" class="placeholder">
                                                        <div id="filePicker"></div>
                                                        <p>或将照片拖到这里，单次最多可选300张</p>
                                                    </div>
                                                </div>
                                                <div class="statusBar" style="display:none;">
                                                    <div class="progress">
                                                        <span class="text">0%</span>
                                                        <span class="percentage"></span>
                                                    </div><div class="info"></div>
                                                    <div class="btns">
                                                        <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

                                <div class="col-sm-10 col-sm-offset-1" style="height:100px">
                                    {{--@include('editor::head')--}}
                                    {{--{!! Form::textarea('content', '', ['class' => 'form-control','id'=>'myEditor']) !!}--}}
                                    <!-- 实例化编辑器 -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="ev_set">
                    <p></p>
                    <div class="over clearfix" style="text-align: center;padding: 10px 0 50px 0">
                        <a href="javascript:void(0);">
                            <button class="btn btn-default" style="margin-right:2.5%">取消</button>
                            <button class="btn btn-noicon btn-green">保存</button>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection


