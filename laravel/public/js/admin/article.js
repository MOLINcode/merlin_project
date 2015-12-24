/**
 * Created by merlin on 15-12-23.
 */
define(function(require,exports,module){
    //引入T
    var T = require('T');

    //图片上传
    $("#MyUploader").iUploader({
        EnableSwitchView: true,
        GridColumnsNum: 5,
        UploadWidth : '70%',
        ColumnsNum: 5,
        OnSelected: function(files){
            /* alert(key + " " + name + " " + size + " " + type); */
        },
        OnProgress : function(file, uploaded, total){
            /* console.log(key + "-" + name + "-" + uploaded +"-" + total); */
        },
        OnStart : function(file){
            /* console.log(key + "-" + name + "-" + size +"-" + type); */
        },
        OnSuccess: function(file){
            /* console.log(key + "-" + name + "-" + size +"-" + type); */
        }
    });
    //导出的方法
    module.exports = {

    };
});
