define(function (require, exports, module) {
        //echarts基础库
        var echarts = require('echarts');
        var T = require('T');
        //JQuery 插件库
        require('jqueryTsbPlugin');


        function setOption(data, opt, instance) {
            //数据驱动，@TODO支持自定义驱动

            if (opt.type instanceof Array) {

                var driver = require('echartsDriverDataMixed');
                //折线图  面积图  柱状图  雷达图
            } else {
                switch (opt.type) {

                    case 'pie'  :   //饼图
                    case 'ring' :   //环形图
                        var driver = require('echartsDriverDataPie');
                        break;

                    case 'gauge':   //仪表盘
                        var driver = require('echartsDriverDataGauge');
                        break;
                    case 'map'  :   //地图
                        var driver = require('echartsDriverDataMap');
                        break
                    case 'radar':   //雷达图
                        var driver = require('echartsDriverDataRadar');
                        break
                    case 'scatter':   //散点图
                        var driver = require('echartsDriverDataScatter');
                        break;
                    case 'line' :   //折线图
                    case 'area' :   //面积图
                    case 'bar'  :   //柱状图
                    default :       //默认
                        driver = require('echartsDriverDataLine');
                        break;
                }
            }
            //交给数据处理驱动器解析
            if (typeof opt.driver == 'function') {
                var option = opt.driver(data, opt, instance);
            } else {
                var option = driver(data, opt, instance);
            }

            if ($.isEmptyObject(option.series[0]) || option.series[0].data.length < 1) {
                $(instance.domId).showNoData();
                return false;
            }

            //事件绑定

            var event = echarts.config.EVENT;

            var events = {
                click: event.CLICK, //单击
                legendSelect: event.LEGEND_SELECTED    //图例选择
            };
            for (var e in events) {
                if (typeof opt[e] == "function") {
                    instance.on(events[e], opt[e]);
                }
            }
            //画图
            if($.isFunction(opt.setOption)){
                var callbackOpt = opt.setOption(option, instance,driver);
                option = $.extend({},option,callbackOpt);
            }
            instance.setOption(option);



            $(instance.domId).showLoading('hide');

            //事件
            /*===========================================
             绑定toolbox的mouseenter事件
             ============================================*/
            //是否开启toolbox
            if (!$.isEmptyObject(option.toolbox) && option.toolbox.show != false) {
                //先设置为隐藏

                instance.setOption({toolbox: {show: false}});
                //绑定mouseenter事件
                $(instance.domId).bind("mouseenter ", function (e) {
                    instance.setOption({toolbox: {show: false}})
                }).bind("mouseleave", function () {
                    instance.setOption({toolbox: {show: false}})
                })
            }
        }

        //画图
        $.fn.echarts = function (setopt) {
            /**
             * 循环画图
             * @TODO 目前这种方法不支持一次请求同时画多图的情况,暂时可使用data闭包回调的方式实现，具体方法见浏览器-网页-弹窗
             *
             */
            return $(this).each(function () {
                //块级元素
                var block = $(this);
                //图表容器
                var chart = $(this).find('[data-chart]');

                try {

                    var oldInstance = echarts.getInstanceById($(chart).attr('_echarts_instance_'));
                    if (oldInstance) {
                        block.unbind("mouseenter").unbind("mouseleave");
                        oldInstance.clear();
                        $(chart).removeAttr('_echarts_instance_');
                        delete oldInstance;
                    }
                    //参数或回调
                    var opt = setopt;
                    if (chart.length < 1) {
                        throw  new Error('找不到图表容器[data-chart]');
                    }


                    //执行回调获取参数
                    if (typeof setopt == 'function') {
                        opt = setopt($(this));
                    }
                    //Loading效果
                    if (opt.showLoading !== false) {
                        block.showLoading();
                    }

                    //实例化echarts                      主题，支持自定义主题
                    if (opt.theme == undefined) {
                        var theme = require('echartsDriverThemeDefaultTsb');
                    } else {
                        var theme = opt.theme;
                    }


                    //实例化
                    var instance = echarts.init($(chart)[0]);


                    $(window).resize(function(){
                        instance.resize();
                    });

                    if($.isFunction(opt.setTheme)){
                        var callbackTheme = opt.setTheme(theme, instance,opt);
                        theme = $.extend({},theme,callbackTheme);
                    }

                    if (!theme) {
                        throw new Error('没有获取到主题');
                    }

                    //设置主题
                    instance.setTheme(theme);


                    //解决弹窗画图问题
                    if ($(chart).width() <= 200) {
                        setTimeout(function () {
                           instance.resize();
                            instance.setTheme(theme);

                        }, 200)
                    }


                    instance.domId = block;
                    var data = {};
                    //回调方式
                    if (typeof opt.data == "function") {
                        var ajaxOpt = opt.data();
                    } else {
                        var ajaxOpt = opt.data;
                    }
                    if (typeof ajaxOpt.url != 'undefined') {
                        //回调数据
                        $.ajax({
                            url: ajaxOpt.url,
                            type: ajaxOpt.method == "get" ? "get" : "post",
                            data: ajaxOpt.data,
                            dataType: "json",
                            success: function (response) {
                                if (typeof ajaxOpt.success == 'function') {
                                    //回调success
                                    data = ajaxOpt.success(response.data);
                                } else {
                                    data = response.data;
                                }

                                //画图
                                if($.isEmptyObject(response.data)) {
                                    block.showNoData();
                                }else{
                                    setOption(data, opt, instance)
                                }

                            },
                            error: function (response) {
                                block.showNoData();
                                //throw new Error('请求失败');
                                return false;
                            }
                        });

                    } else {
                        //静态数据
                        setOption(ajaxOpt, opt, instance)
                    }

                } catch (error) {
                    block.showNoData();
                }
            });
        };

        module.exports = $;
    }

)
;