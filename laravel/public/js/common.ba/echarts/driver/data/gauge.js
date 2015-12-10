define(function (require, b, a) {
    a.exports = function (f, d) {
        var e = {
            series: [],
            tooltip:{
                trigger:"item",
                formatter: "{b}<br/>{c} "+ d.tooltip
            },
            toolbox: {
                show: false
            }
        };
        var color = d.color == undefined ? '#fabb3d' : d.color;
        e.series[0] = {
            name: d.name || "",
            type: "gauge",
            title: {show: false},
            data: [{name: f.name, value: f.value}],
            max: f.max,
            axisLine: {lineStyle: {color: [[f.value / f.max, color], [1, "#f2f4f8"], [1, "#f2f4f8"]]}},
            axisLabel: {show: false},
            splitLine: {show: false},
            axisTick: {show: false},

            detail: {show: false},
            legend: {show: false},

            min: 0
        };

        return e
    }
});