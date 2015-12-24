@extends('layouts.master')
@section('app_css')
    {{App\ViewSpall\ResourceSpall::includeCSS('article')}}
    {{App\ViewSpall\ResourceSpall::includeCSS('upload_image')}}
    {{App\ViewSpall\ResourceSpall::includeCSS('markdown')}}
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
                    <p>文章内容</p>
                    <div class="content">
                        <div class="form-horizontal">

                            <div class="clearfix editor">

                                <div class="col-sm-10 col-sm-offset-1" style="height:100px">
                                    <div id="test-editormd">
                <textarea style="display:none;">### Custom toolbar

```javascript
$(function() {
    var testEditor = editormd("test-editormd", {
        width: "90%",
        height: 640,
        path : '../lib/',
        toolbarIcons : function() {
            // Or return editormd.toolbarModes[name]; // full, simple, mini
            // Using "||" set icons align right.
            return ["undo", "redo", "|", "bold", "hr", "|", "preview", "watch", "|", "fullscreen", "info", "testIcon", "testIcon2", "file", "faicon", "||", "watch", "fullscreen", "preview", "testIcon"]
        },
        toolbarIconsClass : {
            testIcon : "fa-gears"  // 指定一个FontAawsome的图标类
        },
        toolbarIconTexts : {
            testIcon2 : "测试按钮"  // 如果没有图标，则可以这样直接插入内容，可以是字符串或HTML标签
        },

        // 用于增加自定义工具栏的功能，可以直接插入HTML标签，不使用默认的元素创建图标
        toolbarCustomIcons : {
            file   : "&lt;input type="file" accept=".md" /&gt;",
            faicon : "&lt;i class="fa fa-star" onclick="alert('faicon');"&gt;&lt;/i&gt;"
        },

        // 自定义工具栏按钮的事件处理
        toolbarHandlers : {
            /**
             * @param {Object}      cm         CodeMirror对象
             * @param {Object}      icon       图标按钮jQuery元素对象
             * @param {Object}      cursor     CodeMirror的光标对象，可获取光标所在行和位置
             * @param {String}      selection  编辑器选中的文本
             */
            testIcon : function(cm, icon, cursor, selection) {

                //var cursor    = cm.getCursor();     //获取当前光标对象，同cursor参数
                //var selection = cm.getSelection();  //获取当前选中的文本，同selection参数

                // 替换选中文本，如果没有选中文本，则直接插入
                cm.replaceSelection("[" + selection + ":testIcon]");

                // 如果当前没有选中的文本，将光标移到要输入的位置
                if(selection === "") {
                    cm.setCursor(cursor.line, cursor.ch + 1);
                }

                // this == 当前editormd实例
                console.log("testIcon =>", this, cm, icon, cursor, selection);
            },

            testIcon2 : function(cm, icon, cursor, selection) {
                cm.replaceSelection("[" + selection + ":testIcon2](" + icon.html() + ")");
                console.log("testIcon2 =>", this, icon.html());
            }
        },

        lang : {
            toolbar : {
                file : "上传文件",
                testIcon : "自定义按钮testIcon",  // 自定义按钮的提示文本，即title属性
                testIcon2 : "自定义按钮testIcon2",
                undo : "撤销 (Ctrl+Z)"
            }
        },

        onload : function(){
            $("[type=\"file\"]").bind("change", function(){
                alert($(this).val());
                testEditor.cm.replaceSelection($(this).val());
                console.log($(this).val(), testEditor);
            });
        }
    });
});
```
</textarea>
                                    </div>
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
@section('app_js')
    {{App\ViewSpall\ResourceSpall::includeJS('upload_image')}}
    {{App\ViewSpall\ResourceSpall::includeJS('markdown')}}
    <script>
        seajs.use(['article'],function(article){
            article.upload_image();
            article.markdown();
        });
    </script>
@endsection


