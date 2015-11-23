define(function (require, c, d) {
    d.exports = function (s, v) {
        var q = {
            legend: {data: []},
            series: [],
            tooltip: {show: true},
            toolbox: {
                show: true,
                color: ["#37b4b3", "#37b4b3", "#37b4b3", "#37b4b3"],
                feature: {
                    magicType: {show: true, type: ["line", "bar", "stack", "tiled"]},
                    saveAsImage: {show: true, color: "#37b4b3"}
                }
            },
            grid: {
                x2: '10%',
            },
            xAxis: [],
            yAxis: []
        };
        var a = [{type: "category", data: s.labels}];
        var w = [{type: "value"}];
        var t = 0;
        for (var r in s.data) {
            if (typeof s.data[r].data != "undefined") {
                var u = s.data[r].name;
                var i = s.data[r].data
            } else {
                var u = r;
                var i = s.data[r]
            }
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
            q.series.push({name: u, type: j, data: i, itemStyle: p, yAxisIndex: b});
            t++
        }
        if (v.tooltip != undefined) {
            var tips = v.tooltip;
            if (tips instanceof Array) {
            } else {
                tips = [v.tooltip]
            }
            q.tooltip.formatter = function (g) {
                var f = g[0][1] + "<br>";
                for (var k = 0, l = g.length; k < l; k++) {
                    if (typeof tips[k] == "undefined") {
                        var h = tips[0]
                    } else {
                        var h = tips[k]
                    }
                    f += g[k][0] + " : " + g[k][2] + " " + h + "<br>"
                }
                return f
            };
            for (var r in tips) {
                if (r <= 1) {
                    w[r] = {type: "value", axisLabel: {formatter: "{value} " + tips[r]}}
                } else {
                    break
                }
            }
        }
        if (v.category == "y") {
            q.xAxis = w;
            q.yAxis = a
        } else {
            q.yAxis = w;
            q.xAxis = a
        }
        return q
    }
});