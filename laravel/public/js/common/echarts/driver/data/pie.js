define(function (require, b, a) {
    a.exports = function (g, e) {
        var f = {
            legend: {
                orient : 'vertical',
                x : 'left',
                y : 'top',
                data: []
            },
            series: [],
            tooltip: {show: true},
            toolbox: {
                show: true,
                color: ["#37b4b3", "#37b4b3", "#37b4b3", "#37b4b3"],
                feature: {
                    magicType: {show: true, type: ["line", "bar", "stack", "tiled"]},
                    saveAsImage: {show: true, color: "#37b4b3"}
                }
            }
        };
        var h = [];
        for (var d in g.data) {
            if($.isNumeric(d)){
                h.push(g.data[d]);
                f.legend.data.push(g.data[d].name);
            }else{
                f.legend.data.push(d);
                h.push({name: d, value: g.data[d]})
            }
        }
        f.series[0] = {name: g.name || "", type: e.type, data: h};
        if(e.type == 'ring'){
            f.series[0].type = 'pie';
            f.series[0].radius = ['35%', '55%'];
        }
        return f
    }
});