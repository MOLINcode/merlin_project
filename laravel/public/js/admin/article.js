/**
 * Created by merlin on 15-12-23.
 */
define(function(require,exports,module){
    //引入T
    var T = require('T');

    // 图片上传demo
   var upload_image = function() {
        var $ = jQuery,
            $list = $('#fileList'),
        // 优化retina, 在retina下这个值是2
            ratio = window.devicePixelRatio || 1,

        // 缩略图大小
            thumbnailWidth = 100 * ratio,
            thumbnailHeight = 100 * ratio,

        // Web Uploader实例
            uploader;

        // 初始化Web Uploader
        uploader = WebUploader.create({

            // 自动上传。
            auto: false,

            // swf文件路径
            swf:'/js/image-upload/expressInstall.swf',

            // 文件接收服务端。
            server: 'http://webuploader.duapp.com/server/fileupload.php',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择文件，可选。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });

        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function( file ) {
            var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '<div class="info">' + file.name + '</div>' +
                    '</div>'
                ),
                $img = $li.find('img');

            $list.append( $li );

            // 创建缩略图
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
        });

        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                $percent = $li.find('.progress span');

            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<p class="progress"><span></span></p>')
                    .appendTo( $li )
                    .find('span');
            }

            $percent.css( 'width', percentage * 100 + '%' );
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file ) {
            $( '#'+file.id ).addClass('upload-state-done');
        });

        // 文件上传失败，现实上传出错。
        uploader.on( 'uploadError', function( file ) {
            var $li = $( '#'+file.id ),
                $error = $li.find('div.error');

            // 避免重复创建
            if ( !$error.length ) {
                $error = $('<div class="error"></div>').appendTo( $li );
            }

            $error.text('上传失败');
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress').remove();
        });
    }


    var markdown =function(){
        var testEditor = editormd("test-editormd", {
            width: "90%",
            height: 640,
            path : '../lib/',
            watch : false,
            toolbarIcons : function() {
                // Or return editormd.toolbarModes[name]; // full, simple, mini
                // Using "||" set icons align right.
                return ["undo", "redo", "|", "bold", "hr", "|", "preview", "watch", "|", "fullscreen", "info", "testIcon", "testIcon2", "file", "faicon", "||", "watch", "fullscreen", "preview", "testIcon", "file"]
            },
            // toolbarIcons : "full", // You can also use editormd.toolbarModes[name] default list, values: full, simple, mini.
            toolbarIconsClass : {
                testIcon : "fa-gears"  // 指定一个FontAawsome的图标类
            },
            toolbarIconTexts : {
                testIcon2 : "测试按钮Test button"  // 如果没有图标，则可以这样直接插入内容，可以是字符串或HTML标签
            },

            // 用于增加自定义工具栏的功能，可以直接插入HTML标签，不使用默认的元素创建图标
            toolbarCustomIcons : {
                file   : "<input type=\"file\" accept=\".md\" />",
                faicon : "<i class=\"fa fa-star\" onclick=\"alert('faicon');\"></i>"
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
    }


    //导出的方法
    module.exports = {
        'markdown' : markdown,
        'upload_image':upload_image,

    };
});
