@extends('layouts.master')
@section('app_css')
    {{App\ViewSpall\ResourceSpall::includeCSS('article')}}
    {{App\ViewSpall\ResourceSpall::includeCSS('upload_image')}}
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
                    <p class="createTitle">基本信息</p>
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
                                <ul class="ul-gray-alert clearfix alert_group_select">
                                    <li class="select_group_item"><a href="#">test</a><i class="fa fa-times"></i></li>
                                    <li class="group_select">
                                        <div class="btn-group" role="group">
                                            <a type="button" class="dropdown-toggle cursor addTag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-plus"></i>添加
                                            </a>
                                            <ul class="dropdown-menu group_data">
                                                <li  class="group_item"><a href="#">aaa</a></li>
                                                <li  class="group_item"><a href="#">bear</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="ev_set">
                    <p class="createTitle">图片封面</p>
                    <div class="content">
                        <div class="form-horizontal">

                            <div class="clearfix">
                                <div class="col-sm-11 col-sm-offset-1">
                                    <div id="uploader-demo" class="wu-example">
                                        <div id="filePicker" class="webuploader-container"><div class="webuploader-pick">选择图片</div>
                                            <div id="rt_rt_1a79eq4171kc61ooer0pqp85td4" style="position: absolute; top: 0px; left: 0px; width: 94px; height: 44px; overflow: hidden; bottom: auto; right: auto;">
                                                <input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label>
                                            </div>
                                        </div>
                                        <div id="fileList" class="uploader-list"></div>
                                   </div>
                                </div>

                            </div>
                        </div>


                    </div>


                </div>

                <!--内容-->
                <div class="ev_set">
                    <p class="createTitle">文章内容</p>
                    <div class="content">
                        <div class="form-horizontal">
                            <div class="clearfix">
                                <div class="col-sm-11 col-sm-offset-1 editor">
                                    @include('editor::head')
                                    {!! Form::textarea('content', '', ['class' => 'form-control','id'=>'myEditor']) !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="ev_set">
                    <p class="createTitle">操作</p>
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
@section('app_js')
    {{App\ViewSpall\ResourceSpall::includeJS('upload_image')}}
    <script>
        seajs.use(['article'],function(article){
            article.upload_image();
        });
    </script>
@endsection


