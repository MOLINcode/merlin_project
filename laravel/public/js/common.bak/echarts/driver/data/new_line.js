define(function (require, c, d) {
    d.exports = function (s, v) {


        var optionData = [];
        var seriesLine = s[2];
        var seriesArr = [];
        var optionxAxis =s[0];
        var optionyAxis = s[1];

        for (var i in seriesLine) {
            var seriesObj = {
                name: seriesLine[i][0],
                type: 'line',
                smooth: true,
                data: seriesLine[i][1],
                itemStyle: {
                    normal: {
                        lineStyle: {
                            type: 'dotted',
                        },
                    }
                }

            }

            try{
                if(typeof(s[3]) != 'undefined' && s[3][0] == seriesLine[i][0]){
                    seriesObj.markLine={
                        type:"line",
                        data : [
                            [
                                {name: '阈值(ms)', value: s[3][1], xAxis: 0, yAxis: s[3][1],
                                    itemStyle:{
                                        normal:{
                                            color:'#dc143c',
                                            label:{position:'right'}
                                        }
                                    }
                                },
                                {xAxis:optionxAxis[1].length - 1,yAxis: s[3][1]}
                            ]
                        ]
                    }
                }
            }catch(e){
                console.log(e);
            }

            optionData.push(seriesLine[i][0]);
            seriesArr.push(seriesObj);
        }
        var yAxisarr = [];

        for (var j in optionyAxis) {
            var yAxisObj = {
                name: optionyAxis[j],
                nameLocation: 'end',
                type: 'value',
                splitNumber: 5,
                axisLine: {
                    lineStyle: {
                        color: '#dc143c',
                    },
                },
                splitLine: {
                    show: false,
                },
                splitArea: {
                    show: true,
                },

            }
            yAxisarr.push(yAxisObj);

        }

        var xAxisarr = [
            {
                name: optionxAxis[0],
                nameLocation: 'end',
                type: 'category',
                data: optionxAxis[1],
                splitNumber: optionxAxis[1].length - 1,
                boundaryGap: false,
                axisLine: {
                    lineStyle: {
                        color: '#008acd',
                    },
                },
                splitLine: {
                    show: false,
                },
                splitArea: {
                    show: true,
                }
            }
        ];

        option = {
            colors: ['#2ec7c9', '#b6a2de', '#dc143c'],
            tooltip: {
                show: true,
                trigger: 'axis'
            },
            legend: {
                data: optionData,
                y: 'bottom',
                itemGap: 20,
            },
            toolbox: {
                show: true,
                feature: {
                    mark: {
                        show: true,
                        lineStyle: {
                            width: 2,
                            color: '#1e90ff',
                            type: 'dashed',
                        }
                    },
                    dataZoom: {
                        show: true,
                    },
                    dataView: {
                        show: true,
                        readOnly: false,
                    },
                    magicType: {
                        show: true,
                        type: ['line', 'bar'],
                    },
                    restore: {
                        show: true,
                    },
                    saveAsImage: {
                        show: true,
                        type: 'png',
                    }

                },
                x: 'center',
                y: 10,
                itemSize: 14,
            },
            calculable: true,
            grid: {
                x: 42,
                y: 45,
                x2: 63,
                y2: 60,
                borderWidth: 0,
            },
            xAxis: xAxisarr,
            yAxis: yAxisarr,
            series: seriesArr
        };
        return option;
    }
});