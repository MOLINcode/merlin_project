/**
 * Created by merlin on 15-8-5.
 */
define(function (require, b, a) {
    a.exports = function (g, e) {

        var labelTop = {
            normal : {
                color : '#66d180' ,
                label : {
                    show : true,
                    position : 'center',
                    formatter : '{b}',
                    textStyle: {
                        baseline : 'middle',
                        color : '#333',
                    }
                },
                labelLine : {
                    show : false
                }
            }
        };
        var labelFromatter = {
            normal : {
                label : {
                    formatter : function (params){
                        return 100 - params.value + '%'
                    },
                    textStyle: {
                        baseline : 'top',
                    }
                }
            },
        }
        var labelBottom = {
            normal : {
                color: '#ccc',
                label : {
                    show : false,
                    position : 'center',
                    textStyle: {
                        baseline : 'bottom',
                        color : '#333',
                        fontSize : 20,
                    }
                },
                labelLine : {
                    show : false
                }
            },
            emphasis: {
                color: 'rgba(0,0,0,0)'
            }
        };
        var radius = [33, 35];
        option = {
            legend: {
                show : false,
                x : 'center',
                y : 'center',
                data:[
                    '测试进度'
                ]
            },
            title : {
                show : false,
                x: 'center'
            },
            toolbox: {
                show : false,
                feature : {
                    dataView : {show: true, readOnly: false},
                    magicType : {
                        show: false,
                        type: ['pie', 'funnel'],
                        option: {
                            funnel: {
                                width: '20%',
                                height: '30%',
                                itemStyle : {
                                    normal : {
                                        label : {
                                            formatter : function (params){
                                                return 'other\n' + params.value + '%\n'
                                            },
                                            textStyle: {
                                                baseline : 'middle'
                                            }
                                        }
                                    },
                                }
                            }
                        }
                    },
                    restore : {show: true},
                    saveAsImage : {show: true},
                }
            },
            series : [
                {
                    type : 'pie',
                    center : ['50%', '50%'],
                    radius : radius,
                    x:'50%', // for funnel
                    itemStyle : labelFromatter,
                    data : [
                        {name: e.data[0].name, value: e.data[0].value, itemStyle : labelBottom},
                        {name: e.data[1].name, value:e.data[1].value,itemStyle : labelTop}
                    ],
                    clockWise : false,
                },
            ]
        };
        return option;
    }
});
