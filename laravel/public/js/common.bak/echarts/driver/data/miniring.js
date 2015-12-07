define(function (require, b, a) {
    a.exports = function (g, e) {
        var tooltip = e.tooltip == undefined ? '' : e.tooltip;
        var f = {
            legend: {data: [],show:false},
            series: [],
            tooltip: {
                show: true,
                formatter:"{b}<br>{c} "+ tooltip
            },
            toolbox: {
                show: false
            }
        };
        var h = [];
        var i =0;
        for (var d in g.data) {
            console.log(d);
            if($.isNumeric(d)){
                h.push(g.data[d].toFixed(2));
                f.legend.data.push(g.data[d].name);
            }else{
                f.legend.data.push(d);
                h.push({name: d, value: g.data[d].toFixed(2)})
            }
            if(i == 0){
                var label = true;
            }else{
                var label = false;
            }
            h[i].itemStyle = {
                normal:{
                    label:{
                        show:label
                    }
                }
            };
            i++;
        }

        f.series[0] = {name: g.name || "", type: e.type, data: h};
        f.series[0].type = 'pie';
        f.series[0].radius = [30, 34];
        f.series[0].center = ["50%","50%"]

        return f
    }
});