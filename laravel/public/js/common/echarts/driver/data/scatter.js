define(function (require, c, d) {
    d.exports = function (s, v) {
        var unitx = s.labels[0];
        var unity = s.labels[1];
        var q = {
            tooltip: {
                trigger: 'item',
                formatter : function (params) {
                    return params.seriesName +'<br>'
                        + params.value[0] + unitx+'&nbsp;&nbsp;&nbsp;&nbsp;'
                        + params.value[1] + unity;
                },
                position: function(params){
                    if(params[0]<100){
                        params[0] = params[0]+100;
                    }else{
                        params[0] = params[0]-100;
                    }
                    if(params[1]<100){
                        params[1] = params[1]+100;
                    }else{
                        params[1] = params[1]-100;
                    }
                    return [params[0],params[1]];
                }
            },
            toolbox: {
                show: true,
                color: ["#37b4b3"],
                feature: {
                    saveAsImage: {show: true, color: "#37b4b3"}
                }
            },
            dataZoom: {},
            xAxis:[],
            yAxis:[],
            legend : {
                data :[]
            },
            series:[]
        };
        q.grid = {
            x2:80
        }
        q.xAxis = [
            {
                type : 'value',
                scale:true,
                axisLabel: {
                    formatter : function(v) {
                        return + v + unitx;
                    }
                }
            }
        ];
        q.yAxis =[
            {
                type : 'value',
                scale:true,
                position:'right',
                axisLabel: {
                    formatter : function(v) {
                        return + v + unity;
                    }
                }
            }
        ];
        q.dataRange = {
            min: 0,
            max: 100,
            y: 'center',
            text:['高','低'],           // 文本，默认为数值文本
            //color:['blue','yellow'],
            calculable : true
        };
        for(var r in s.data){
            var i = {
                symbol:'circle',
                color:'#37b4b3',
                type:'scatter',
                name: s.data[r].d,
                data:[[s.data[r].a, s.data[r].b, s.data[r].c]]
            };
            q.series.push(i);
        }
        return q;
    }
});