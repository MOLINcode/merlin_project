define(function (require, b, a) {
    a.exports = function (data, opt) {

        var option = {
            tooltip : {
                trigger: 'item'
            },
            legend: {
                data:[]
            },
            toolbox: {
                show : false
            },
            polar : [
                {
                    indicator : []
                }
            ],
            series:[]
        };

        var series = [];
        for (var h in data.data) {
                var name = h;
                var dData = data.data[name]


            option.legend.data.push(name);
            series.push({name: name, value: dData});
        }
        option.series[0] = {type:'radar',name:'',data:series};

        for(var i in data.labels){
            var tmp = {
                text:i,
                max:data.labels[i]
            }
            option.polar[0].indicator.push(tmp);
        }
        console.log(option);
        return option;
    }
});