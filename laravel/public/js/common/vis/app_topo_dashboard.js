define(function (require, exports, module) {
    var nodes;
    var edges;
    var network;
    var data;
    var group_color;
    var container;
    var moving = false;
    var pop_left;
    var pop_top;
    var resource;
    var options;
    var allNodes;
    var allEdges;
    var highlightActive;
    var bindOperations = {};
    var highLightFunction = null;
    var editMode = true;
    var T = require('T');
    var TSB = require('TSB');
    require('app_vis_topo');
    require('app_vis_tool');

    //初始化数据
    function initData(dom_id, params) {
        if (params.nodes.length == 0) {
            $('#' + dom_id).removeClass('loading').addClass('nodata');
            return false;
        }
        $('.loading').removeClass('loading');
        // create a network
        resource = params;
        container = document.getElementById(dom_id);
        nodes = new vis.DataSet();
        edges = new vis.DataSet();
        nodes.add(params.nodes);edges.add(params.edges);
        group_color = params.color;
        data = {
            nodes: nodes,
            edges: edges
        };
        return true;
    }


    function drawTopo(callUserFunc) {
        options = {
            groups: {
                cloud: {
                    shape: 'image',
                    image: '/resource/img/app_topo/cloud.png',
                    color: group_color.cloud,
                    size:15
                },
                'app': {
                    shape: 'image',
                    image: '/resource/img/app_topo/php_green.png',
                    color: group_color.app,
                    size: 30
                },
                'app_normal': {
                    shape: 'image',
                    image: '/resource/img/app_topo/app_normal.png',
                    color: group_color.app,
                    size: 30
                },
                'app_slow': {
                    shape: 'image',
                    image: '/resource/img/app_topo/app_slow.png',
                    color: group_color.app,
                    size: 30
                },
                'app_very_slow': {
                    shape: 'image',
                    image: '/resource/img/app_topo/app_very_slow.png',
                    color: group_color.app,
                    size: 30
                },
                'app_stop': {
                    shape: 'image',
                    image: '/resource/img/app_topo/app_stop.png',
                    color: group_color.app,
                    size: 30
                },
                'app_error': {
                    shape: 'image',
                    image: '/resource/img/app_topo/app_error.png',
                    color: group_color.app,
                    size: 30
                },

                'server': {
                    shape: 'image',
                    image: '/resource/img/app_topo/server.png',
                    color: group_color.app,
                    size: 30
                },
                'nginx': {
                    shape: 'image',
                    image: '/resource/img/app_topo/nginx.png',
                    color: group_color.app,
                    size: 30
                },
                'apache': {
                    shape: 'image',
                    image: '/resource/img/app_topo/apache.png',
                    color: group_color.app,
                    size: 30
                },
                'IIS': {
                    shape: 'image',
                    image: '/resource/img/app_topo/IIS.png',
                    color: group_color.app,
                    size: 30
                },
                'tomcat': {
                    shape: 'image',
                    image: '/resource/img/app_topo/tomcat.png',
                    color: group_color.app,
                    size: 30
                },
                'curl': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.app,
                    size: 15
                },
                'io': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.app,
                    size: 15
                },
                database: {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'sqlserver': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'mongodb': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'weblogic': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'memcache': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'redis': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'mysql': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'db2': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'oracle': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'Oracle': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'PostgreSQL': {
                    shape: 'image',
                    image: '/resource/img/app_topo/db.png',
                    color: group_color.database,
                    size: 15
                },
                'other_RESTApi': {
                    shape: 'image',
                    image: '/resource/img/app_topo/cloud.png',
                    color: group_color.database,
                    size: 15
                },
            },
            autoResize:true,
            height:"600px",
            nodes: {
                size: 15,
                font: {
                    size: 10
                }
            },
            edges: {
                arrows: 'to',
                smooth:{
                    enabled:false
                },
                color:{
                    color:'#dddddd',
                    highlight:'green'
                },
                length:200,
                width:1,
                selectionWidth:0
            },
            physics: {
                barnesHut: {
                    gravitationalConstant: -8000,
                    centralGravity: 1
                }
            },
            layout: {
                randomSeed: 0,
                hierarchical: {
                    enabled: false,
                    levelSeparation: 150,
                    direction: 'LR',   // UD, DU, LR, RL
                    sortMethod: 'hubsize' // hubsize, directed
                }
            },
            interaction:{
                multiselect:true,
            },
            clickToUse:false
        };
        if (network != undefined) {
            network.destroy();
            network = undefined;
        }
        allNodes = nodes.get({returnType:"Object"});
        $.each(allNodes,function(id,values){
            delete allNodes[id].x;
            delete allNodes[id].y;
        });
        $.each(data.nodes._data,function(id,values){
            delete data.nodes._data[id].x;
            delete data.nodes._data[id].y;
        });
        network = new vis.Network(container, data, options);

        allEdges = edges.get({returnType:"Object"});
        network.on("click",neighbourhoodHighlight);
        if ($.isFunction(callUserFunc)) {
            callUserFunc(network);
        }
        $.each(resource.nodes, function (k, node) {
            if (node.title !== undefined) {
                network.on("afterDrawing", function (ctx) {
                    var nodeId = node.id;
                    var nodePosition = network.getPositions([nodeId]);
                    if(navigator.Actual_Name == 'chrom'){
                        ctx.font = 'normal 5px Arial';
                    }else{
                        ctx.font = 'normal 10px Arial';
                    }

                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.strokeStyle = 'white';
                    ctx.fillStyle = 'white';
                    ctx.strokeText(node.title, nodePosition[nodeId].x, nodePosition[nodeId].y);
//                    ctx.circle(nodePosition[nodeId].x, nodePosition[nodeId].y, 10);
                    ctx.stroke();
                });
            }
        });

        //取消联动效果
        network.once('afterDrawing', function () {
            network.setOptions({nodes: {physics: false}});
        });
        $('#loadingBar').css('opacity', 1);
        //拓扑图加载进程
        network.on("stabilizationProgress", function (event) {
            var widthFactor = event.iterations / event.total;
            $('#loadingBar').html(Math.round(widthFactor * 100) + '%');
        });
        //拓扑图加载结束
        network.once("stabilizationIterationsDone", function () {
            $('#loadingBar').css('opacity', 0);
        });
        var option = {
            position: {x: 0, y: 0},
            scale: 1.0,
            offset: {x: 0, y: 0},
            animation: {
                duration: 100,
                easingFunction: 'easeInOutQuad'
            }
        };
        network.fit({animation: option});
    }

    //切换显示模式
    $('.convert_module').click(function () {
        $(this).addClass('active');
        $('.hide_line').removeClass('active');
        drawTopo();
    });

    /**
     * @param domElement
     * @param event
     * @param effect
     * @param callback
     */
    var bindEventToElement = function (effect, domElement, event, callback) {
        $(document).delegate(domElement, event, function () {
            if (network == undefined) {
                return;
            }
            switch (effect) {
                case 'fit':
                    $(domElement).bind(event, function () {
                        var option = {
                            position: {x: 0, y: 0},
                            scale: 1.0,//放大一倍显示
                            offset: {x: 0, y: 0},
                            animation: {
                                duration: 1000,
                                easingFunction: 'easeInOutQuad'
                            }
                        };
                        network.fit({animation: option});
                    });
                    break;
                case 'focus':
                    $(domElement).bind(event, function () {
                        var node_id = resource.nodes[Math.floor(Math.random() * (resource.nodes.length))].id;
                        var option = {
                            position: {x: 0, y: 0},
                            scale: 1.0,
                            offset: {x: 0, y: 0},
                            animation: {
                                duration: 1000,
                                easingFunction: 'easeInOutQuad'
                            },
                            lockedOnNode: node_id
                        };
                        network.selectNodes([node_id]);
                        network.focus(node_id, option);
                    });
                    break;
                case 'convert':
                        options = {
                            layout: {
                                randomSeed: 0,
                                hierarchical: {
                                    enabled: false,
                                    levelSeparation: 150,
                                    direction: 'LR',   // UD, DU, LR, RL
                                    sortMethod: 'hubsize' // hubsize, directed
                                }
                            },
                        };
                        $(this).addClass('active').siblings().removeClass('active');
                        var convert_data = $(this).parent().find('.active').data();
                        if (convert_data.type == 'enable') {
                            if (convert_data.value == 'false') {
                                options.layout.hierarchical.enabled = false;
                            }
                        } else {
                            options.layout.hierarchical.enabled = true;
                            options.layout.hierarchical[convert_data.type] = convert_data.value;
                        }
                        network.setOptions(options);
                    break;
            }

            if ($.isFunction(callback)) {
                callback();
            }
        });

    };

    var RebindOperations = function () {
        for (var i in bindOperations) {
            network.on(bindOperations[i]['event'], function (e) {
                bindOperations[i]['callback'](e, network);
            });
        }
    };

    var bindEventToTopo = function (event, callback) {
        bindOperations[event] = {event: event, callback: callback};
        if (network != undefined) {
            network.on(event, function (e) {
                callback(e, network);
            });
        }
    };

    function neighbourhoodHighlight(params) {
        hideNormalLine(false);
        var updateEdges = [];
        // if something is selected:
        if (params.nodes.length > 0) {
            $(allNodes)
            if($.isFunction(highLightFunction)){
                highLightFunction(params.nodes[0]);
            }
            //聚焦
//            var option = {
//                position: {x: 0, y: 0},
//                scale: 1.0,
//                offset: {x: 0, y: 0},
//                animation: {
//                    duration: 1000,
//                    easingFunction: 'easeInOutQuad'
//                },
//                lockedOnNode: params.nodes[0]
//            };
//            network.focus(params.nodes[0], option);
            highlightActive = true;
            var i,j;
            var selectedNodes = params.nodes;
            var connectedEdges = [];
            for(i in selectedNodes){
                var connectedEdge = network.getConnectedEdges(selectedNodes[i]);
                for(j in connectedEdge){
                    if($.inArray(connectedEdge[j],connectedEdges) == -1){
                        connectedEdges.push(connectedEdge[j]);
                    }
                }
            }
//            connectedEdges = network.getConnectedEdges(selectedNode);
            $.each(allEdges,function(id,value){
                if($.inArray(id,connectedEdges) > -1){
                    allEdges[id].color = 'green';
                }else{
                    allEdges[id].color = '#dddddd';
                }
                updateEdges.push(allEdges[id]);
            });
            var degrees = 1;

            // mark all nodes as hard to read.
            for (var nodeId in allNodes) {
                if (allNodes[nodeId].hiddenLabel === undefined) {
                    allNodes[nodeId].hiddenLabel = allNodes[nodeId].label;
                    allNodes[nodeId].label = undefined;
                }
            }

            var connectedNodes = [];
            for(i in selectedNodes){
                var connectedNode = network.getConnectedNodes(selectedNodes[i]);
                for(j in connectedNode){
                    if($.inArray(connectedNode[j],connectedNodes) == -1){
                        connectedNodes.push(connectedNode[j]);
                    }
                }
            }
//            var connectedNodes = network.getConnectedNodes(selectedNode);
            var allConnectedNodes = [];

            // get the second degree nodes
            for (i = 1; i < degrees; i++) {
                for (j = 0; j < connectedNodes.length; j++) {
                    allConnectedNodes = allConnectedNodes.concat(network.getConnectedNodes(connectedNodes[j]));
                }
            }

            // all second degree nodes get a different color and their label back
            for (i = 0; i < allConnectedNodes.length; i++) {
                if (allNodes[allConnectedNodes[i]].hiddenLabel !== undefined) {
                    allNodes[allConnectedNodes[i]].label = allNodes[allConnectedNodes[i]].hiddenLabel;
                    allNodes[allConnectedNodes[i]].hiddenLabel = undefined;
                }
            }

            // all first degree nodes get their own color and their label back
            for (i = 0; i < connectedNodes.length; i++) {
                allNodes[connectedNodes[i]].color = undefined;
                if (allNodes[connectedNodes[i]].hiddenLabel !== undefined) {
                    allNodes[connectedNodes[i]].label = allNodes[connectedNodes[i]].hiddenLabel;
                    allNodes[connectedNodes[i]].hiddenLabel = undefined;
                }

                if (allNodes[connectedNodes[i]].size !== undefined) {
                    allNodes[connectedNodes[i]].label = allNodes[connectedNodes[i]].hiddenLabel;
                    allNodes[connectedNodes[i]].hiddenLabel = undefined;
                }
            }

            // the main node gets its own color and its label back.
            for(i in selectedNodes){
                allNodes[selectedNodes[i]].color = undefined;
                if (allNodes[selectedNodes[i]].hiddenLabel !== undefined) {
                    allNodes[selectedNodes[i]].label = allNodes[selectedNodes[i]].hiddenLabel;
                    allNodes[selectedNodes[i]].hiddenLabel = undefined;
                }
            }

        }
        else if (highlightActive === true) {
            $.each(allEdges,function(id,value){
                allEdges[id].color = '#dddddd';
                updateEdges.push(allEdges[id]);
            });
            // reset all nodes
            for (var nodeId in allNodes) {
                allNodes[nodeId].color = undefined;
                if (allNodes[nodeId].hiddenLabel !== undefined) {
                    allNodes[nodeId].label = allNodes[nodeId].hiddenLabel;
                    allNodes[nodeId].hiddenLabel = undefined;
                }
            }
            highlightActive = false
        }

        // transform the object into an array
        var updateArray = [];
        for (nodeId in allNodes) {
            if (allNodes.hasOwnProperty(nodeId)) {
                var pos = network.getPositions([nodeId]);
                allNodes[nodeId].x = pos[nodeId].x;
                allNodes[nodeId].y = pos[nodeId].y;
                updateArray.push(allNodes[nodeId]);
            }
        }
        nodes.update(updateArray);
        edges.update(updateEdges);
    }

    var updateNodesPosition = function(params,app_id){
        var scale = network.getScale();
        if(app_id != undefined){
            $.each(params.nodes,function(id,values){
                if(id == app_id){
                    allNodes[id]['x'] = values.x;
                    allNodes[id]['y'] = values.y;
                }else{
                    allNodes[id]['x'] = (values.x*150) * (scale + params.scale);
                    allNodes[id]['y'] = (values.y*150) * (scale + params.scale);
                }
            });
        }else{
            $.each(params.nodes,function(id,values){
                if($.isNumeric(id)){
                    allNodes[id]['x'] = (values.x*100) * (params.scale_in);
                    allNodes[id]['y'] = (values.y*100) * (params.scale_in);
                }else{
                    allNodes[id]['x'] = (values.x*200) * (params.scale_in);
                    allNodes[id]['y'] = (values.y*200) * (params.scale_in);
                }

            });
        }
        var updateArray = [];
        for (var nodeId in allNodes) {
            updateArray.push(allNodes[nodeId]);
        }
        nodes.update(updateArray);
        var option = {
            position: {x: 0, y: 0},
            scale: 1.0,
            offset: {x: 0, y: 0},
            animation: {
                duration: 100,
                easingFunction: 'easeInOutQuad'
            }
        };
        network.fit({animation: option});
        network.setOptions({
            edges: {
                smooth:{
                    enabled:false
                },
            },
            layout: {
                hierarchical: {
                    enabled: false,
                }
            }
        });
        network.setOptions({
            edges: {
                smooth:{
                    enabled:false
                },
            },
            layout: {
                hierarchical: {
                    enabled: false,
                }
            }
        });
    }

    var setTopoOption = function (options) {
        network.setOptions(options);
    };

    var setHighLingFunction = function(callback){
        highLightFunction = callback;
    }

    var hideNormalLine = function(status)
    {
        var updateEdges = [];
        var selectEdges = network.getSelectedEdges();
        $.each(allEdges,function(id,edge){
            if(status){
                if($.inArray(id,selectEdges) == -1){
                    allEdges[id].hidden = true;
                }
                updateEdges.push(allEdges[id]);
            }else{
                allEdges[id].hidden = false;
                updateEdges.push(allEdges[id]);
            }

        });
        edges.update(updateEdges);
    }

    var getNetwork = function(){
        return network;
    }

    module.exports = {
        initTopoData: initData,
        drawTopo: drawTopo,
        bindEventToElement: bindEventToElement,
        bindEventToTopo: bindEventToTopo,
        setTopoOption: setTopoOption,
        RebindOperations: RebindOperations,
        getNetwork:getNetwork,
        neighbourhoodHighlight:neighbourhoodHighlight,
        updateNodesPosition:updateNodesPosition,
        hideNormalLine:hideNormalLine,
        setHighLingFunction:setHighLingFunction
    }
});