define(function(require,exports,module){
    var zrender = require('zrender');
    var Rectangle = require('zrenderRectangle');
    var Polygon = require('zrenderPolygon');
    var LineShape = require('zrenderLine');
    var Text = require('zrenderText');
    var Event = require('zrenderEvent');
    var drawPic = function(option){
        var zr = zrender.init(document.getElementById(option['id']));
        var getMax = function(data){
            var max = 0;
            for(i in data){
                if(data[i]>max){
                    max = data[i];
                }
            }
            return max;
        }
        //坐标轴绘制
        var line = function(dom_height,dom_width,dom_left,dom_bottom,rate,color){
            dom_left = 40;
            zr.addShape(new LineShape({
                style : {
                    xStart : dom_left,
                    yStart : dom_height - dom_bottom,
                    xEnd : dom_left,
                    yEnd : dom_bottom,
                    lineWidth : 1,
                    lineType : 'solid',    // default solid
                    text : lang_mobile.user_num
                },
                hoverable:false,
                zlevel:1
            }));
            zr.addShape(new LineShape({
                style : {
                    xStart : dom_left,
                    yStart : dom_height - dom_bottom,
                    xEnd : dom_width - dom_left + dom_width * 0.05,
                    yEnd : dom_height - dom_bottom,
                    lineWidth : 1,
                },
                hoverable:false,
                zlevel:1
            }));
            var line_distance = dom_height * 0.1;
            var k = 0;
            for(var i = 1; i < 8; i++){
                if(Math.floor(line_distance * i / rate) != k){
                    k = Math.floor(line_distance * i / rate);
                    zr.addShape(new Text({
                        style : {
                            x: dom_left - 20,
                            y: dom_height - dom_bottom - line_distance * i,
                            lineWidth : 1,
                            text : k,
                            textFont : 'normal 10px verdana',
                            textAlign : 'center',
                            textBaseline : 'left'
                        },
                        hoverable:false,
                        zlevel:1
                    }));
                }
                zr.addShape(new LineShape({
                    style : {
                        xStart : dom_left,
                        yStart : dom_height - dom_bottom - line_distance * i,
                        xEnd : dom_width,
                        yEnd : dom_height - dom_bottom - line_distance * i,
                        lineWidth : 1,
                        strokeColor : '#eee',
                        lineType : 'solid',    // default solid
                        //text :line_distance * i / rate,
                        //textPosition:'left'

                    },
                    hoverable:false,
                    zlevel:0
                }));

            }
        }
        //矩形
        var rect = function(dom_width,dom_height,pic_width,pic_height,position_left,text,dom_bottom,color,label,label_title){
            var target_id = undefined;
            var shape = undefined;
            zr.addShape(new Rectangle({
                style:{
                    x: position_left,
                    y: dom_height - pic_height - dom_bottom,
                    width: pic_width,
                    height: pic_height,
                    color:color,
                    text:text,
                    textPosition:'top',
                    textFont : 'normal 15px verdana',
                },
                hoverable : false,
                clickable : true,
                param:label,
                onclick: function(params){
                    option.click(params);
                },
                highlightStyle:{
                    strokeColor:color,
                    lineWidth:1
                },
                zlevel:1
            }));
            zr.addShape(new Text({
                style : {
                    x: position_left + pic_width/2,
                    y: dom_height - dom_bottom + 25,
                    lineWidth : 1,
                    text : label_title,
                    color:'#000',
                    textFont : 'normal 13px verdana',
                    textAlign : 'center',
                    textBaseline : 'bottom',
                    maxWidth:pic_width * 1.8
                },
                hoverable : false,
                onmouseover:function(e){
                    $('#pop_over').html(label);
                    $('#pop_over').css('left', Event.getX(e.event));
                    $('#pop_over').css('top', Event.getY(e.event) + 380);
                    $('#pop_over').css('display', 'block');
                },
                onmouseout:function(){
                    $('#pop_over').css('display', 'none');
                },
                zlevel:1
            }));
        };

        var arrow = function(dom_width,dom_height,pic_width,pic_height,pic_left,pre_pic_height,color,text,dom_bottom){
            if(pre_pic_height==0){
                pre_pic_height=50;
            }
            zr.addShape(
                new Rectangle({
                    style:{
                        x: pic_left + pic_width * 0.05,
                        //y: dom_height - pre_pic_height/2 - pic_height/2 - dom_bottom,
                        y: dom_height - 120,
                        width: pic_width * 0.7,
                        height: pic_height,
                        color:color,
                        text:text+'%',
                        textPosition:'inside',
                        textFont : 'bold 15px verdana'
                    },
                    hoverable : false,
                    zlevel:1
                })
            );
            zr.addShape(
                new Polygon({
                    style: {
                        pointList: [[pic_left + pic_width * 0.70,dom_height - 130], [pic_left + pic_width * 0.70, dom_height - 110 + pic_height], [pic_left + pic_width * 0.90, dom_height - 120 +pic_height/2]],
                        color: color
                    },
                    zlevel:1,
                    hoverable : false,
                })
            );
        };

        var dom_width = parseInt($('#'+option['id']).css('width'));
        var dom_height = parseInt($('#'+option['id']).css('height'));
        var max_value = getMax(option['data1']);
        var length = option.data1.length
        var rate = (dom_height * 0.6) / max_value;
        var pic_width = dom_width/(length + 1) * 0.5;
        var pic_distance = dom_width/(length + 1) * 0.5;
        var dom_left = dom_width/(length + 1) * 0.6;
        var dom_bottom = 50;
        if(max_value==0){
            $('#'+option.id).parent().removeClass('loading').addClass('nodata');
            return false;
        }
        option.color = ['#1972E4','#575652','#f1f1e9'];
        for(var i = 0; i < length; i++){
            rect(dom_width,dom_height,pic_width,option['data1'][i] * rate,pic_distance*i + pic_width*i + dom_left + 30,option['data1'][i],dom_bottom,option['color'][0],option['labels'][i],option['labels_title'][i]);
            if(i<length-1){
                arrow(dom_width,dom_height,pic_distance,30,pic_distance*i + pic_width * (i + 1) + dom_left +30, option['data1'][i+1]*rate,option['color'][1],option['data2'][i],dom_bottom);
            }
        }
        line(dom_height,dom_width,dom_left,dom_bottom,rate,option['color'][2]);
        zr.render();
    }
//        var option = {
//            labels:['点击','查看','注册','退出'],
//            data1:[300,200,0,10],
//            data2:[66,0,'-'],
//            id:'main',
//            click:function(params){console.log(params)}
//        };
    module.exports = {
        drawPic:drawPic
    };
});