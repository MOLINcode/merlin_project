/**
 * Created by admin-chen on 14-7-19.
 */
define(function (require, exports, module) {
    //echarts基础库
    require('echartsPlugin');
    var common_date = require('date_control');
    var T = require('T');

	var common_report_chart = (function($, window, document, undefined){
		return {
			/**
			 * 获取公共数据
			 */
			getCommonData:function(target_id){
//				var range_time = common_date.getCommonTimeRange();
				return {
					target_id:target_id
//					start_time:range_time.start_time,
//					end_time:range_time.end_time
				}
			},
			/**
			 * 绘制波浪图
			 * @param domId
			 * @param url
			 * @param tpl
			 */
			drawWaveFigure:function(className){
				$('.'+className).each(function(){
					var data = $(this).attr('data').split(',');
					$(this).sparkline(data,{ type:"line", height:20});
				});
			},
			/**
			 * 绘制圆形图
			 * @param className
			 */
			drawPieChart:function(className){
				var green = '#468847';
				var yellow = '#fabb3d';
				var red = '#ff5454';
				$('.'+className).each(function () {
					var socre = Number($(this).attr('data-percent'));
					switch (true) {
						case socre >= 80:
							color = green;
							break;
						case socre >= 60:
							color = yellow;
							break;
						case socre < 60:
							color = red;
							break;
					}
					$(this).easyPieChart({
						lineWidth: 5,
						scaleColor: false,
						barColor: color,
						rotate: false
					});
				});
			},
			/**
			 * 绘制线性图
			 * @param domId
			 * @param colorId
			 * @param data
			 */
			drawLineChart:function(domId,colorId,data){
				$("#"+domId).html('');
				var show_data = data.show_data,
					xKey = data.xkey,
					xLabels = data.xLabels,
					ykeys = data.ykeys,
					prefix = data.prefix,
					colors = data.colors,
					labels = data.labels;
				var color_html = '';
				for(var i=0;i<labels.length;i++){
					color_html += '<input type="button" class="chart-tips-button" style="background-color: '+colors[i]+'" disabled="">'+labels[i];
				}
				$("#"+colorId).html(color_html);
				Morris.Line({
					element: domId,
					data: show_data,
					lineColors: colors,
					gridTextColor: '#505050',
					xkey: xKey,
					xLabels:xLabels,
					ykeys: ykeys,
					labels: labels,
					hideHover: 'auto',
					ymin:0,
					yLabelFormat:function (y) { return (Math.ceil(y*100)/100) + prefix; }
				});
			},
			/**
			 * 绘制面积图
			 * @param domId
			 * @param colorId
			 * @param data
			 */
			drawAreaChart:function(domId,colorId,data){
				$("#"+domId).html('');
				var show_data = data.show_data,
					xKey = data.xkey,
					xLabels = data.xLabels,
					ykeys = data.ykeys,
					prefix = data.prefix,
					colors = data.colors,
					labels = data.labels;
				var color_html = '';
				for(var i=0;i<labels.length;i++){
					color_html += '<input type="button" class="chart-tips-button" style="background-color: '+colors[i]+'" disabled="">'+labels[i];
				}
				$("#"+colorId).html(color_html);
				Morris.Area({
					element: domId,
					data: show_data,
					lineColors: colors,
					gridTextColor: '#505050',
					xkey: xKey,
					xLabels:xLabels,
					ykeys: ykeys,
					labels: labels,
					hideHover: 'auto',
					ymin:0,
					yLabelFormat:function (y) { return (Math.ceil(y*100)/100) + prefix; }
				});
			},
			/**
			 * 绘制横向柱状图
			 * @param domId
			 * @param data
			 */
			drawLateralChart:function(domId,data){
				$.plot("#"+domId, data.show_data, {
					colors:data.colors,
					grid:{
						borderWidth : 1,
						borderColor:'#ddd'
					},
					ymin:0,
					series: {
						bars: {
							horizontal : true,
							show: true,
							align: "center",
							barWidth:0.1,
							fill:1
						}

					},
					yaxis: {
						mode: "categories",
						tickLength: 0
					}
				});
			},
			/**
			 * 获取报告监测点列表或历史快照中的监测点列表
			 * submitData是对象，必须包含的属性是：
			 * {
			 *  type:"分为报告('report_monitor_list')和历史快照历史('history_snapshot_monitor_list')两种监测点列表类型",
			 *  target_id:"任务id",
			 *  service_type:"服务类型"，
			 *  target_type:
			 *  start_time:"开始时间"，
			 *  end_time:"结束时间"
			 * }，
			 * callBackFunc:执行回调函数
			 */
			getMonitorList:function(domId,submitData,callBackFunc){
				var get_monitor_list_url = '/site/board/monitor/list';
				T.ajaxLoad(get_monitor_list_url,domId,submitData,function(){
					callBackFunc();//执行回调函数
				});
			},
			/**
			 * 获取报告列表中已勾选的监测点
			 * type = 'report'返回值的监测点用逗号“,”隔开
			 * type = 'history_snapshot'返回值的监测点值是int
			 * @returns {string}
			 */
			getSelectedMonitor:function(type){
				if(typeof type == 'undefined') type = 'report';//默认是'report'
				if(type == 'report'){
					var selected_monitor = '',
						all_monitor_num = 0,
						selected_monitor_num = 0;
					$('.monitor_class').each(function(){
						all_monitor_num++;
						if($(this).is(':checked')){
							selected_monitor += $(this).val()+','
							selected_monitor_num++;
						}
					})
					$("#monitor_all_num_id").html(all_monitor_num);
					$("#monitor_selected_num_id").html(selected_monitor_num);
					return selected_monitor;

				}else if(type == 'history_snapshot'){
					var monitor_id = '';
					$("#show_monitor_list_id").children().each(function(){
						if($(this).hasClass('active')){
							monitor_id = $(this).attr('monitor_id');
							return false;
						}
					});
					return monitor_id;
				}
			},
			/**
			 * 获取报告中详细数据列表的时间段
			 */
			getDetailsDateRange: function(domId){
				var details_range_time = $("#"+domId).val();
				var range_time_arr = details_range_time.split(',');
				return {start_time:range_time_arr[0],end_time:range_time_arr[1]};
			},
			/**
			 * 创建详细数据列表的时间段
			 * @param domId
			 */
		   createDetailsDateRange:function(domId){
				var range_time = common_date.getCommonTimeRange();
				var time_diff = parseInt(range_time.end_time) - parseInt(range_time.start_time);
				var intervel_time = '';
				if(date_range_enum.last30minute == time_diff){
					intervel_time = 30*60*1000;
				}else if(date_range_enum.last1hour == time_diff){
					intervel_time = date_range_enum.last1hour;
				}else if(date_range_enum.last6hour == time_diff){
					intervel_time = date_range_enum.last6hour;
				}else if(date_range_enum.last12hour == time_diff){
					intervel_time = date_range_enum.last12hour;
				}else if(date_range_enum.last1day == time_diff){
					intervel_time = date_range_enum.last1day;
				}else if(date_range_enum.last7day == time_diff){
					intervel_time = 24*3600*1000;
				}else if(date_range_enum.last30day == time_diff){
					intervel_time = 24*3600*1000;
				}
				var date_range_html = '';
				var count = parseInt(time_diff/intervel_time);
				for(var i=0;i<count;i++){
					var start_time = range_time.start_time+i*intervel_time;
					var end_time = range_time.start_time+(i+1)*intervel_time;
					var range_time_name = new Date(start_time).format('yyyy-MM-dd hh:mm')+'—'+new Date(end_time).format('yyyy-MM-dd hh:mm');
					if(end_time<=range_time.end_time){
						date_range_html += '<option value="'+start_time+','+end_time+'">'+range_time_name+'</option>';
					}else{
						break;
					}
				}
				$("#"+domId).html(date_range_html);
			},
			/**
			 * echarts图表工具的配置
			 */
			echartsToolBoxConf:{
				show: true,
				feature: {
					mark: {
						show: true
					},
					dataView: {
						show: false,
						readOnly: true
					},
					magicType: {
						show: true,
						type: ['line', 'bar', 'stack', 'tiled']
					},
					restore: {
						show: true
					},
					saveAsImage: {
						show: true
					}
				}

			},
			/**
			 * 绘制两个Y轴echarts的接口
			 * 可绘制的图形有：
			 * Line,Area
			 * 对应的chartType: 'line','area'
			 * */
			drawMixedLineCharts:function(chartType,domId,data,title){
				var title = $('#'+domId).find('.basic-title span').html();
				if(typeof data != 'object' ||  typeof data.showData != 'object'  || !data.showData || data.showData.length <1 || data.labels.length <1){
					T.showNoData(domId);
					return;
				}
				var RestTitle = $($('#'+domId).data('reset')).find('.basic-title span');
				if(RestTitle.length >0){
					var title = RestTitle.html();
				}
				var leftUnit = data.leftUnit;
				var rightUnit = data.rightUnit;

				var option =common_report_chart.chartDefaultConfig(chartType,title,data);
				var yAxis = [
					{
						type: 'value',
						axisLabel:{
							formatter: '{value}'+leftUnit
						},
						axisLine:{
							lineStyle:{color:'#bbbbbb'}   //X轴颜色
						}
					},
					{
						type: 'value',
						axisLabel:{
							formatter: '{value}'+rightUnit
						},
						axisLine:{
							lineStyle:{color:'#bbbbbb'}   //X轴颜色
						}
					}
				];
				option.tooltip = {
					formatter: function(params) {
						return params[0][1] + '<br/>'
							+ params[0][0] + ' : ' + params[0][2] + leftUnit+' <br/>'
							+ params[1][0] + ' : ' + params[1][2] + rightUnit;
					}
				};
				option.yAxis = yAxis;
				option.grid.x2 = 70;
				option.data = data.showData;
				option.labels = data.labels;
				$('#'+domId).echarts(option);
				$('#'+domId).removeClass('loading').removeClass('nodata');

			},

			/**
			 * 绘制地图
			 * 可绘制的图形有：
			 * Map
			 * 对应的chartType: Map
			 * */
			drawMapCharts:function(domId,data,Type,clickCallBackFunc){
				var data = data;
				if(typeof clickCallBackFunc == 'undefined'){
					clickCallBackFunc = function(params){};
				}
				$('#'+domId).removeClass('loading').removeClass('nodata').echarts({
					type:'map',
					title: {
						text: ''
					},
					click: clickCallBackFunc,
					tooltipHover: '{b} : {c}'+data.unit,
					data: data.data,
					min: data.bar.min,
					max: data.bar.max,
					mapType: Type,
					rangeFormatter:'{value} ' + data.unit
				});
			},
		  drawChartsGauge: function(domId,data,color){
			  var option = {
					  type:'gauge',
					  color:color,
					  data:data

				 };

			  $('#'+domId).echarts(option);
		  },
		  drawChartsPie : function(domId,data){

			  option = {
				  type:'pie',
				  legend:false,
				  series : [
					  {
						  type : 'pie',
						  radius : [30,34],
						  itemStyle :{
							  normal : {

								  label : {
									  formatter : function (){return '' },
									  textStyle: {
										  color:"#444"
									  }

								  }

							  }
						  },
						  data : data
					  }
				  ],
				  tooltip:{
					  formatter: function(param){
						  var tip = param[1] + '<br>' + param[2].toFixed(2);
						  return tip;
					  }
				  }
			  };

			  $('#'+domId).echarts(option);

		  },
			drawMircoCharts:function(domId,data,opt){
				var config = this.chartDefaultConfig('line','',data,false);
				config.toolbox.show = false;
				config.tooltip.show =false;
				config.colors = ["#fff"];
				config.symbolList = null;
				config.xAxis[0].show = false;
				config.yAxis[0].show = false;
				config.grid = {
					x: 20,
					x2: 20,
					y: 20,
					y2: 20,
					borderWidth: 0
				};
				config.itemStyle = {
					symbol:'none',
					smooth:false,
					itemStyle:{
						normal:{
							color:"#37b4b3"
						}
					}
				};


				config.xAxis[0].splitLine ={
					show:false
				};
				config.yAxis[0].splitLine ={
					show : false
				};

				config.xAxis[0].splitArea ={
					show:false
				};
				config.yAxis[0].splitArea ={
					show : false
				};

				config.xAxis[0].axisTick = {
					show:false
				};
				var tmpData = [];

				for(var i=0;i<config.data.length;i++){
					var value = config.data[i][config.labels[0]];
					if(value != '-'){
						tmpData.push(config.data[i]);
					}
				}
				config.data = tmpData;

				for(var i=0;i<config.data.length;i++){
					if(i==0 || i==config.data.length -1){
						var value = config.data[i][config.labels[0]];
						config.data[i][config.labels[0]] = {
							value:value,
							symbol:'circle'
						}
					}
				}

				var option = $.extend(config,opt);


				$('#'+domId).echarts(option);
			},

		   /*
			统一图表显示方式
			 */
		  chartDefaultConfig:function(type,title,data,legend){
			  var unit = data.unit ? data.unit : '';
			 // var unit = unit ? unit : '';
			  title = title ? title : '';
			  legend = legend == false ? false : true;

			  var option =  {
				  type:type,    //图表类型，支持line，area，bar
				  title:{
					  text: title   //图表标题

				  },
				  xAxis: [
					  {
						  type: 'category',  //x轴类型
						  axisLine:{
							  lineStyle:{color:'#bbbbbb'}   //X轴颜色
						  },
						  axisLabel:{
							  formatter:'{value}'
							  //interval:0,
							 // rotate:60
						  }

					  }
				  ],
				  yAxis: [
					  {
						  type: 'value', //Y轴类型
						  name: '',
						  axisLabel: {
							  formatter:'{value} ' + unit  //Y轴formart
						  },
						  axisLine:{
							  lineStyle:{color:'#bbbbbb'}  //y轴颜色
						  }
					  }
				  ],
				  tooltip: {

					  unit: ' '+unit //设置tooltip单位
				  },
				  grid: {
					  x:80,
					  y:60,
					  x2:40,
					  y2:80
				  },

				  colors:['#1ac7ca','#b7a1e0','#de66ab','#ffba7b','#da797f','#8d97b4','#e6d100','#96b64b','#96706c','#5493f1'],
				  toolbox: {
					  show: true,
					  color:'#37b4b3',
					  feature: {
						  magicType: {
							  show: true,
							  type: ['line', 'bar', 'stack', 'tiled']
						  },
						  saveAsImage: {
							  show: true
						  }
					  }
				  }

			  };
			  if(legend){
				  option.legend =  {
					  y: 'bottom'
				  }
			  }else{
				  option.legend = false;
			  }

			  if(type == 'bar'){
				  option.xAxis[0].type = 'value';
				  option.xAxis[0].axisLabel.formatter = '{value} ' + unit;
				  option.yAxis[0].type = 'category';
				  option.yAxis[0].axisLabel = {};

			  }
			  if(type == 'ring' || type == 'pie'){
				  option.series = [{
					  name:data.labels.name,
					  data: data.showData

				  }];
				  if(type == 'ring'){
					  option.series.radius = ['80%','90%'];
					  option.series.itemStyle = {
						  emphasis:{
							  label:{
								  show:true,
								  position:'center',
								  textStyle:{
									  fontSize:'25',
									  fontWeight:'bold'
								  }
							  }
						  }
					  };

				  }

				  option.legend.data = data.labels.legend;

				  option.grid = false;
				  option.xAxis = null;option.yAxis = null;
				  option.toolbox = {};

				  return option;

			  }else{

				  option.data = data.showData;
				  option.labels = data.labels;
			  }

			  return option;
		  },

			/**
			 * 绘制echarts的接口
			 * 可绘制的图形有：
			 * Line,Area,Bar,Pie
			 * 对应的chartType: 'line','area','bar','pie'
			 * 做横向对比的时候传入的xType和yType参数分别是'value'和'category'
			 * */
		  drawCharts:function(type,domId,data,title,legend){
				if(typeof data != 'object' ||  typeof data.showData != 'object'  || !data.showData || data.showData.length <1 || data.labels.length <1){
					T.showNoData(domId);
					$('#'+domId).removeClass('loading');
				}else{
					var Chartsoption = null;
					var RestTitle = $($('#'+domId).data('reset')).find('.basic-title span');
					if(RestTitle.length >0){
					   // var title = RestTitle.html();
					}
					 Chartsoption =common_report_chart.chartDefaultConfig(type,title,data,legend);
					$('#'+domId).removeClass('loading').removeClass('nodata').echarts(Chartsoption);

				}

		  }

		}

	})(jQuery, window, document, undefined);
	
	module.exports = common_report_chart;
});
