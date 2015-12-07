/**
 * Created by merlin on 15-9-17.
 */
define(function (require, c, d) {
    d.exports = function (s, v) {
        var q = {
            legend: {data: []},
            series: [],
            tooltip : {
                trigger: 'axis',
                axisPointer:{
                    show: true,
                    type : 'cross',
                    lineStyle: {
                        type : 'dashed',
                        width : 1
                    }
                },
            },
            calculable : true,
            toolbox: {
                show : true,
                color: ["#37b4b3", "#37b4b3", "#37b4b3", "#37b4b3"],
                feature : {
                    mark : {show: true},
                    dataZoom : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            grid: {
                x: '9%',
                y: '12%',
                x2: '12%',
                y2: '9%',
                // borderWidth: 0,
            },
            xAxis: [],
            yAxis: []
        };

        var a = [{type: "value"}];
        var w = [{
            type: "value",
            axisLine: {
                lineStyle: {
                    color: '#dc143c'
                }
            }

        }];
        var aSeries = [];


        var t = 0;
        for (var r in s.data) {
            var u= s.data[r][0];
            var i= s.data[r][1];
            var j = s.data[r].type == undefined ? v.type : s.data[r].type;
            var p = {normal: {}};
            if (j == "area") {
                j = "line";
                p.normal.areaStyle = {type: "default"}
            }
            var b = 0;
            if (v.tooltip instanceof Array && t == 1 && v.tooltip.length > 1) {
                b = 1
            }
            q.legend.data.push(u);
            q.series.push({name: u, type: 'line', data: i});
            t++
        }
        if (v.category == "y") {
            q.xAxis = w;
            q.yAxis = a
        } else {
            q.yAxis = w;
            q.xAxis = a
        }
        return q;


    }
});