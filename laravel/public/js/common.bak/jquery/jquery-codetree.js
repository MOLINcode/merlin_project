define(function(require,exports,module) {
    var $ = require('jquery');
    $.fn.makeCodeTree = function (data) {
        console.log(data);
        return this.each(function () {
            var $this = $(this),
                maps = data.maps,
                treeData = data.tree;
            function makeNode(nodeData) {
                var node = "";
                for(var key in nodeData){
                    var info = maps[key];

//                    node += '<li class="code-tree-node" data-node_id="'+parseInt((parseInt(info.wt)/1000) *100)+'">' +
//                        '<div class="code-node-info" style="border-bottom: 1px solid #DFCCCC">' +
//                        '<div class="code-node-text">';
                    if(info.exception == 1){
                        node += '<li class="code-tree-node" data-node_id="'+parseInt((parseInt(info.wt)/1000) *100)+'">' +
                        '<div class="code-node-info red" style="border-bottom: 1px solid #DFCCCC">' +
                        '<div class="code-node-text">';
                    }else{
                        node += '<li class="code-tree-node" data-node_id="'+parseInt((parseInt(info.wt)/1000) *100)+'">' +
                        '<div class="code-node-info" style="border-bottom: 1px solid #DFCCCC">' +
                        '<div class="code-node-text">';
                    }
                    if(nodeData[key] != 0){
                        node += '<span class="code-node-icon"></span>';
                        if(info.exception == 1){
                            node +='<img src="/resource/img/bug.png">'
                        }
                    }


                    var ct = parseInt(info.ct);
                    if(ct < 0) ct = '-';
                    node += (info.mn + '</div>' +
                    '<div class="code-node-type" style="border-left: 1px solid #DFCCCC;padding-left: 10px;">'+ parseInt((parseInt(info.cpu)/1000)*100)/100 +'</div>' +
                    '<div class="code-node-exclusive" style="border-left: 1px solid #DFCCCC;padding-left: 10px">' + parseInt((parseInt(info.wt)/1000) *100)/100+ '</div>' +
                    '<div class="code-node-length" style="border-left: 1px solid #DFCCCC;padding-left: 10px">' +ct+ '</div>' +
                    '</div>');

                    /*if(info.hasOwnProperty('ps')){
                     node += '<div class="code-type-details">';
                     for(var i = 0; i< info.ps.length; i++){
                     node += '<p>'+(typeof info.ps[i] === "object" ? JSON.stringify(info.ps[i]):info.ps[i])+'</p>';
                     }
                     node += '</div>';
                     }*/

                    /*子节点*/
                    if(nodeData[key] != 0){
                        node += '<ul class="code-tree-nodes">';
                        node += makeNode(nodeData[key]);
                        node += '</ul>';
                    }

                    node += '</li>';
//                    node_wt=parseInt((parseInt(info.wt)/1000) *100)/100;


                }

                return node;
            }


//            var tree = '<div class="code-tree">' +
//                '<ul class="code-tree-nodes">' +
//                '<li class="code-tree-node code-tree-title">' +
//                '<div class="code-node-info">' +
//                '<div class="code-node-text">堆栈： <a class="code-open" href="#">全部展开</a> | <a class="code-collapse" href="#">全部收起</a></div>' +
//                '<div class="code-node-type">CPU时间（ms）</div>' +
//                '<div class="code-node-exclusive">总时长（ms）</div>' +
//                '<div class="code-node-length">调用（次数）</div>' +
//                '</div>' +
//                '</li>' +
//                '</ul>' +
//                '<ul class="code-tree-nodes">';

            var tree='';
            tree += makeNode(treeData);
            tree += '</ul></div>';
            $this.html(tree);


            /*事件绑定*/
//            $this.on("click", ".code-node-icon", function () { //展开折叠树
//
//                $(this).closest(".code-tree-node").toggleClass("open");
//
//            }).on("click", ".code-open", function (e) { //展开所有
//
////                    $this.find(".code-tree-node").addClass("open");
//                    $('#code_tree_id').find(".code-tree-node").addClass("open");
//                    e.preventDefault();
//
//                }).on("click", ".code-collapse", function (e) { //折叠所有
//
////                    $this.find(".code-tree-node").removeClass("open");
//                    $('#code_tree_id').find(".code-tree-node").removeClass("open");
//                    e.preventDefault();
//
//                });

            $this.on("click", ".code-node-icon", function () { //展开折叠树

                $(this).closest(".code-tree-node").toggleClass("open");

            });

        });
    }
});

