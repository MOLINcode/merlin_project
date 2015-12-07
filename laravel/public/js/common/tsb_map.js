/**
 * Created by admin-chen on 14-10-17.
 */
define(function (require, exports, module) {
	var $ = jQuery = require('jquery');
	var tsb_map = (function(){
		return {
			/**
			 * 绘制地图
			 * @param params 是一个对象，结构说明如下
			 * {
			 *      mapContainer:'map_container', //地图容器的domId
			 *      title:'世界地图', //地图的title
			 *      tooltipVisible:true, //提示信息的可见度
			 *      tooltipFormatter:'点击进入该国家<br/>{b}' //鼠标移动上去显示的内容
			 *      rangeDataMin:0, //数据段的最大值
			 *      rangeDataMax:100, //数据段的最大值
			 *      mapType:'world', //要显示的地图类型
			 *      data:[{name: '北京',value: 50)},] //显示地图上各块颜色的数据
			 *      clickFunc:'函数名'， //点击地图块将要触发的函数，包含一个参数，该参数是echarts传入的
			 *
			 * }
			 */
			drawMap:function(params){
				require(
					[
						'echarts',
						'echarts/chart/map'
					],
					function (ec) {
						var mapChart = ec.init(document.getElementById(params.mapContainer));
						var ecConfig = require('echarts/config');
						//触发点击事件
						mapChart.on(ecConfig.EVENT.MAP_SELECTED,params.clickFunc);

						option = {
							title: {
								text : params.title,
							},
							tooltip : {
								show:params.tooltipVisible,
								trigger: 'item',
								formatter: params.tooltipFormatter
							},
							dataRange: {
								min: params.rangeDataMin,
								max: params.rangeDataMax,
								color:['#24AB1C','#42DD3E','#BFF762','#F7D73F','#F79932','#E71610'],
								text:['高','低'],           // 文本，默认为数值文本
							   // splitNumber:6,
								calculable : true
							},
							series : [
								{
									type: 'map',
									mapType: params.mapType,
									selectedMode : 'single',
									roam:true, //滚轮缩放
									itemStyle:{
										normal:{label:{show:false}}, //显示地区名称
										emphasis:{label:{show:true}} //鼠标移动上去显示名称
									},
									data:params.data
								}
							]
						};
						mapChart.setOption(option, true);
					}
				);
			}
		};
	})();
	
	module.exports = tsb_map;
});