define(function (require, c, d) {
    var line = require('echartsDriverDataLine');
    d.exports = function(data,opt){
        var option = line(data,opt);
        option.tooltip.show = false;
        option.xAxis[0].show = false;
        option.yAxis[0].show = false;
        option.toolbox.show =false;
        option.legend.show =false;

        if(option.series[0].data.length > 1){
            var v0 = option.series[0].data[0];

            option.series[0].data[0] = {
                symbol:'circle',
                value:v0
            };

            var length = option.series[0].data.length - 1;
            var vl = option.series[0].data[length];
            option.series[0].data[length] = {
                symbol:'circle',
                value:vl
            };
        }

        return option;
    };


});