@extends('layouts.master')
@section('app_css')
    {{App\ViewSpall\ResourceSpall::includeCSS('article')}}
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



        {!! Form::open(['route' => 'admin.article.store', 'method' => 'post','class'=>'main-status','enctype'=>'multipart/form-data']) !!}

            <div class="inner">
                <!--基本信息-->
                <div class="ev_set">
                    <p class="createTitle">基本信息</p>
                    <div class="content">
                        <div class="form-horizontal">
                            <div class="clearfix">
                                <label for="test_name" class="control-label">文章名称</label>
                                <div class="col-sm-4">
                                    {!! Form::text('title', '', ['class' => 'form-control','placeholder'=>'文章名称']) !!}
                                </div>
                            </div>

                            <div class="clearfix">
                                <label for="test_name" class="control-label">所属分类</label>
                                <div class="col-sm-4">
                                    {!! Form::select('cate_id',$all_cate, null, ['class' => 'form-control']) !!}
                                    {{--<select name="cate_id" id="" class="form-control">
                                        @foreach($all_cate as $key =>$val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>--}}
                                </div>
                            </div>

                            <div class="clearfix">
                                <label for="test_name" class="control-label">所属标签</label>
                                <div class="col-sm-6">
                                    {{--<input type="text" class="form-control" name="tags" placeholder='回车确定' id='tags'>--}}
                                    {!! Form::text('tags', '', ['class' => 'form-control','placeholder'=>'回车确定','id'=>'tags']) !!}
                                </div>
                            </div>
                            <div class="clearfix">
                                <label for="choice_file" class="col-sm-3 control-label">文章封面</label>
                                <div class="col-sm-6">
                                    {!! Form::file('pic', ['class' => 'form-control']) !!}
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
                    <div class="over clearfix" style="text-align: center;padding: 10px 0 70px 0">
                        <a href="javascript:void(0);">
                            {{--<button class="btn btn-default" style="margin-right:2.5%">取消</button>
                            <button class="btn btn-noicon btn-green" >保存</button>
                            {!! Form::reset('取消', ['class' => 'btn btn-default']) !!}--}}
                            {!! Form::submit('保存', ['class' => 'btn btn-noicon btn-green']) !!}
                        </a>
                    </div>
                </div>

            </div>
        {!! Form::close() !!}
        {{--</form>--}}

    </div>

@endsection
@section('app_js')
    <script>

        seajs.use('article',function(){
            //tag
            $('#tags').tokenfield({
                autocomplete: {
                    source: <?php echo App\Models\Tag::getTagStringAll() ?>,
                    delay: 100
                },
                showAutocompleteOnFocus: !0,
                delimiter: [","]
            })
        })
    </script>
@endsection


