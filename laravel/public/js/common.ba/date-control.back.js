/**
 * Created by admin-chen on 14-6-16.
 */
define(function (require, exports, module) {
	var $ = jQuery = require('jquery');
	require('jqueryCookie')($);
	require('dateTimePicker');
	var TSB = require('TSB');

	var common_date =

		(function($, window, document, undefined){
			var date = new Date();
			var now_time = date.getTime();
			var date2str = function(x,y) {
				var z = {M:x.getMonth()+1,d:x.getDate(),h:x.getHours(),m:x.getMinutes(),s:x.getSeconds()};
				y = y.replace(/(M+|d+|h+|m+|s+)/g,function(v) {return ((v.length>1?"0":"")+eval('z.'+v.slice(-1))).slice(-2)});
				return y.replace(/(y+)/g,function(v) {return x.getFullYear().toString().slice(-v.length)});
			};
			var init_time = {
				'as_now_time':1,//是格数
				'custom_time':1, //是格数
				'hour_silder_value':date2str(new Date(),"hh"),
				'minute_silder_value':date2str(new Date(),"mm"),
				'custom_slider_date':date2str(new Date(),"yyyy-MM-dd hh:mm")
			};

			/**
			 * 初始化时间方法
			 */
			var initTimeFun = function(){
				//截止当前时间
				var date = new Date();
				var now_time = date.getTime();

				if(typeof $.cookie('now_time_space_num') == 'undefined') $.cookie('now_time_space_num',init_time.as_now_time,{path:'/'});
				if(typeof $.cookie('as_now_time_name') == 'undefined')$.cookie('as_now_time_name',lang_time.thirty_minutes,{path:'/'});
				if(typeof $.cookie('as_now_time') == 'undefined') $.cookie('as_now_time',30*60*1000,{path: '/'});

				if(typeof $.cookie('custom_time_space_num') == 'undefined') $.cookie('custom_time_space_num',init_time.custom_time,{path:'/'});
				if(typeof $.cookie('hour_silder_value') == 'undefined') $.cookie('hour_silder_value',init_time.hour_silder_value,{path:'/'});
				if(typeof $.cookie('minute_silder_value') == 'undefined') $.cookie('minute_silder_value',init_time.minute_silder_value,{path:'/'});
				if(typeof $.cookie('as_custom_time_name') == 'undefined')$.cookie('as_custom_time_name',lang_time.thirty_minutes,{path:'/'});
				if(typeof $.cookie('as_custom_time') == 'undefined') $.cookie('as_custom_time',30*60*1000,{path: '/'});
				if(typeof $.cookie('custom_picker_time') == 'undefined') $.cookie('custom_picker_time',date.getTime(),{path: '/'});
				if(typeof $.cookie('custom_hour_time') == 'undefined') $.cookie('custom_hour_time',init_time.hour_silder_value*60*60*1000,{path: '/'});
				if(typeof $.cookie('custom_minute_time') == 'undefined') $.cookie('custom_minute_time',init_time.minute_silder_value*60*1000,{ path: '/'});
				if(typeof $.cookie('custom-slider-date') == 'undefined') $.cookie('custom-slider-date',init_time.custom_slider_date,{ path: '/'});

				var end_time = parseInt(now_time) - parseInt($.cookie('as_now_time'));
				$('#now-time-slider-label').text($.cookie('as_now_time_name'));

				var hour_silder_value = $.cookie('hour_silder_value');
				var minute_silder_value = $.cookie('minute_silder_value');

				var custom_time_name = '<span class="time-border" style="">'+hour_silder_value+'</span>:<span class="time-border-right" style="">'+minute_silder_value+'</span>';
				$('#custom_show_time_id').html(custom_time_name);
				$('#custom-slider-label').text($.cookie('as_custom_time_name'));
				$('#custom-slider-date').text($.cookie('custom-slider-date'));

				//初始化时间
				var end_time = parseInt($.cookie('custom_picker_time')/1000)*1000;
				var start_time = end_time - parseInt($.cookie('as_custom_time'));
				$.cookie('start_time',start_time,{ path: '/'});
				$.cookie('end_time',end_time,{ path: '/'});

			};
			/**
			 * 加载date控件
			 */
			var showDatePicker = function(domId){
				$.fn.datetimepicker.dates['en'] = {
					days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
					daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
					daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
					months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
					monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					today: "Today",
					meridiem:['am','pm']
				};
				$.fn.datetimepicker.dates['cn'] = {
					days: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
					daysShort: ['日','一','二','三','四','五','六'],
					daysMin: ['日','一','二','三','四','五','六'],
					months: ['一月','二月','三月','四月','五月','六月',
						'七月','八月','九月','十月','十一月','十二月'],
					monthsShort: ['一月','二月','三月','四月','五月','六月',
						'七月','八月','九月','十月','十一月','十二月'],
					today: "今天",
					meridiem:['上午','下午']
				};

				$('#'+domId).datetimepicker({
					weekStart: 1,
					language:lang_common.language,
					// todayBtn:  1,
					autoclose: 1,
					// todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					//startDate:new Date(2014,5,12),
					endDate:new Date(),
					initialDate:new Date(parseInt($.cookie('custom_picker_time')))
				}).on('changeDate',function(ev){
					var date =  new Date(ev.date);//带有时区的时间戳date
					var time_diff = new Date().getTimezoneOffset()*60000;
					var timeStamp = date.getTime()+time_diff;
					var date1 = new Date(timeStamp);//不带有时区的date
					$.cookie('custom_picker_time',timeStamp,{path:'/'});

					var hour_silder_value = $.cookie('custom_hour_time')/(3600*1000);
					var minute_silder_value = $.cookie('custom_minute_time')/(60*1000);
					if(hour_silder_value < 10) hour_silder_value = '0'+ hour_silder_value;
					if(minute_silder_value < 10) minute_silder_value = '0'+minute_silder_value;

					$('#custom-slider-date').html(date1.format('yyyy/MM/dd') + ' '+hour_silder_value+':'+minute_silder_value);

				});
			};

			/**
			 * 加载截止到当前时间的控件
			 */
			var showTimeSlider = function(domId,type){
				TSB.slider('#'+domId,{
					range: 'min',
					value:$.cookie('now_time_space_num'),
					min: 1,
					max: 5,
					slideFun:function(event,ui){
						transAsNowTimeFormat(ui.value,type);
						$.cookie('now_time_space_num',ui.value,{path:'/'});
					}
				});
			};

			/**
			 * 加载截止到自定义时间的控件
			 */
			var showCustomTimeSlider = function(domId,type){
				TSB.slider('#'+domId,{
					range: 'min',
					value:$.cookie('custom_time_space_num'),
					min: 1,
					max: 5,
					slideFun:function(event,ui){
						transAsNowTimeFormat(ui.value,type);
						$.cookie('custom_time_space_num',ui.value,{path:'/'});
					}
				});
			};

			/**
			 * 翻译截止当前时间的格式
			 * @param value
			 */
			var transAsNowTimeFormat = function(value,type){
				var date_value = lang_time.thirty_minutes;
				var timestamp = 30*60;
				switch (value){
					case 1:
						date_value = lang_time.thirty_minutes;
						timestamp = 30*60*1000;
						break;
					case 2:
						date_value = lang_time.one_hour;
						timestamp = 60*60*1000;
						break;
					case 3:
						date_value = lang_time.six_hours;
						timestamp = 6*60*60*1000;
						break;
					case 4:
						date_value = lang_time.twelve_hours;
						timestamp = 12*60*60*1000;
						break;
					case 5:
						date_value = lang_time.one_day;
						timestamp = 24*60*60*1000;
						break;
//					case 6:
//						date_value = lang_time.seven_days;
//						timestamp = 7*24*60*60*1000;
//						break;
//					case 7:
//						date_value = lang_time.thirty_days;
//						timestamp = 30*24*60*60*1000;
//						break;
					default :
						date_value = lang_time.thirty_minutes;
						timestamp = 30*60*1000;
				}

				if(type == 'as_now_time'){
					$('#now-time-slider-label').text(date_value);
					$.cookie('as_now_time',timestamp,{ path: '/'});
					$.cookie('as_now_time_name',date_value,{ path: '/'});
				}else if(type == 'custom_time'){
					//自定义时间--range拖动事件
					$('#custom-slider-label').text(date_value);
					$.cookie('as_custom_time',timestamp,{ path: '/'});
				}
			};

			/**
			 * 加载自定义的小时控件
			 */
			var showTimeHourSlider = function(domId){
				TSB.slider('#'+domId,{
					orientation: "vertical",
					range: 'min',
					value:$.cookie('hour_silder_value'),
					step:1,
					min: 0,
					max: 23,
					slideFun:function(event,ui){
						var custom_picker_time = parseInt($.cookie('custom_picker_time'));
						var date1 = new Date(custom_picker_time);//不带有时区的date

						$.cookie('custom_hour_time',ui.value*60*60*1000,{path:'/'});
						var hour_silder_value = $.cookie('custom_hour_time')/(3600*1000);
						var minute_silder_value = $.cookie('custom_minute_time')/(60*1000);
						if(hour_silder_value < 10) hour_silder_value = '0'+hour_silder_value;
						if(minute_silder_value < 10) minute_silder_value = '0'+minute_silder_value;
						var custom_time_name = '<span class="time-border" style="">'+hour_silder_value+'</span>:<span class="time-border-right" style="">'+minute_silder_value+'</span>';
						$.cookie('hour_silder_value',hour_silder_value,{path:'/'});
						$.cookie('minute_silder_value',minute_silder_value,{path:'/'});
						$('#custom_show_time_id').html(custom_time_name);
						$('#custom-slider-date').html(date1.format('yyyy/MM/dd') + ' '+
						hour_silder_value+':'+minute_silder_value);
					},
					changeFun:function(event,ui){
						//$( "#"+domId ).slider( "value",10);
					}
				});
			};

			/**
			 * 加载自定义分钟控件
			 * @param domId
			 */
			var showTimeMinuteSilder = function(domId){
				TSB.slider('#'+domId,{
					orientation: "vertical",
					range: 'min',
					value:$.cookie('minute_silder_value'),
					min: 0,
					max: 59,
					slideFun:function(event,ui){
						var custom_picker_time = parseInt($.cookie('custom_picker_time'));
						var date1 = new Date(custom_picker_time);//不带有时区的date

						$.cookie('custom_minute_time',ui.value*60*1000,{path:'/'});
						var hour_silder_value = $.cookie('custom_hour_time')/(3600*1000);
						var minute_silder_value = $.cookie('custom_minute_time')/(60*1000);
						if(hour_silder_value < 10) hour_silder_value = '0'+hour_silder_value;
						if(minute_silder_value < 10) minute_silder_value = '0'+minute_silder_value;
						var custom_time_name = '<span class="time-border" style="">'+hour_silder_value+'</span>:<span class="time-border-right" style="">'+minute_silder_value+'</span>';
						$.cookie('hour_silder_value',hour_silder_value,{path:'/'});
						$.cookie('minute_silder_value',minute_silder_value,{path:'/'});
						$('#custom_show_time_id').html(custom_time_name);
						$('#custom-slider-date').html(date1.format('yyyy/MM/dd') + ' '+
						hour_silder_value+':'+minute_silder_value);
					}
				});
			};


			/**
			 * 更新时间范围
			 * */
			var drawCommonTimeRange = function(){
				var date = new Date();
				var now_time = parseInt(date.getTime());
				var as_now_time_name = $.cookie('as_now_time_name');
				var as_now_time = parseInt($.cookie('as_now_time'));
				var custom_picker_time = parseInt($.cookie('custom_picker_time'));
				var custom_hour_time = parseInt($.cookie('custom_hour_time'));
				var custom_minute_time = parseInt($.cookie('custom_minute_time'));
				var returnData = null;
				if($("#as_now_time_id").hasClass('active')){
					$.cookie('current_time_flag',1,{path:'/'});
					$.cookie('custom_time_flag',0,{path:'/'});
					$.cookie('as_now_time_name',$('#now-time-slider-label').text(),{ path: '/'});
					var start_time = parseInt((now_time - as_now_time));
					var end_time = parseInt(now_time);
					var name = lang_time.nearly+as_now_time_name+'('+lang_time.from+(new Date(end_time).format('yyyy-MM-dd hh:mm'))+')<i class="fa fa-caret-down" style="margin-left:10px;"></i>';
					$.cookie('start_time',parseInt(start_time/1000)*1000,{ path: '/'});
					$.cookie('end_time',parseInt(end_time/1000)*1000,{ path: '/'});
					returnData = {name:name};
				}

				if($("#custom_time_id").hasClass('active')){
					$.cookie('current_time_flag',0,{path:'/'});
					$.cookie('custom_time_flag',1,{path:'/'});
					$.cookie('as_custom_time_name',$('#custom-slider-label').text(),{ path: '/'});
					$.cookie('custom-slider-date', $('#custom-slider-date').text(),{ path: '/'});
					var as_custom_time_name = $.cookie('as_custom_time_name');
					var d = new Date(custom_picker_time);
					var new_format = d.format('yyyy-MM-dd')+' 00:00:00';
					new_format=new_format.replace("-", "/").replace("-", "/");
					var new_d = new Date(new_format);
					var end_time = parseInt(new_d.getTime()) + custom_hour_time + custom_minute_time;
					var start_time = end_time - parseInt($.cookie('as_custom_time'));
					var name = lang_common.last_time+as_custom_time_name+'('+lang_common.until+(new Date(end_time).format('yyyy-MM-dd hh:mm'))+')<i class="fa fa-caret-down" style="margin-left:10px;"></i>';
					$.cookie('start_time',parseInt(start_time/1000)*1000,{ path: '/'});
					$.cookie('end_time',parseInt(end_time/1000)*1000,{ path: '/'});
					returnData = {start_time:parseInt(start_time/1000)*1000,end_time:parseInt(end_time/1000)*1000,name:name};
				}
				return returnData;
			};

			var getDiffTimeRange = function(time){
				var output;
				switch (time)
				{
					case 1800000:
						output = '30'+lang_common.minute;
						break;
					case 3600000:
						output = '1'+lang_common.hours;
						break;
					case 21600000:
						output = '6'+lang_common.hours;
						break;
					case 43200000:
						output = '12'+lang_common.hours;
						break;
					case 86400000:
						output = '1'+lang_common.day;
						break;
//					case 604800000:
//						output = '7'+lang_common.day;
//						break;
				}
				return output;
			};

			/**
			 * 获取公共的时间范围
			 * */
			var getCommonTimeRange = function(){
				drawCommonTimeRange();
				var start_time = parseInt($.cookie('start_time'));
				var end_time = parseInt($.cookie('end_time'));
				return {start_time:start_time,end_time:end_time};
			};


			return {
				showDatePicker:showDatePicker,
				showTimeSlider:showTimeSlider,
				showCustomTimeSlider:showCustomTimeSlider,
				showTimeHourSlider:showTimeHourSlider,
				showTimeMinuteSilder:showTimeMinuteSilder,
				getCommonTimeRange:getCommonTimeRange,
				initTimeFun:initTimeFun,
				drawCommonTimeRange:drawCommonTimeRange
			}
		})(jQuery, window, document, undefined);


	var initTimeControl = function($){

		$(function(){
			var event_enum = {
				event_date: 'common_date'//公共时间事件
			};
			if(typeof $.cookie('current_time_flag') == 'undefined') {$.cookie('current_time_flag',1,{path:'/'});}
			if(typeof $.cookie('custom_time_flag') == 'undefined') {$.cookie('custom_time_flag',0,{path:'/'});}


			var oDiv1=document.getElementById('set-ping-id');
			var oDiv2=document.getElementById('set-ping-c');
			var obtnSetButton=document.getElementById('set-time-btn');
			var obtnSetPingButton=document.getElementById('set-ping-sub-btn');

			if(typeof oDiv1 != 'object' || typeof oDiv2 != 'object' || typeof obtnSetButton != 'object' || typeof obtnSetPingButton != 'object') return false;

			if(oDiv1 == null || oDiv2 == null || obtnSetButton == null || obtnSetPingButton == null) return false;

			$('.btn[data-dismiss="modal"]').click(function(){
				oDiv2.style.display = 'none';
				$(oDiv1).find('.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
			});

			$(oDiv2).blur(function(){
				//$(this).hide();
			});

			oDiv1.onclick=function()
			{
				if(oDiv2.style.display=='block')
				{
					oDiv2.style.display='none';
					$(oDiv1).find('.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
				}
				else
				{
					common_date.initTimeFun();
					if($.cookie('custom_time_flag') == 1) {
						$("#ping-time-s1").tab('show');
					}
					common_date.showDatePicker('datetimepicker');
					$('#datetimepicker .prev').html('<i  class="glyphicon glyphicon-arrow-left"></i>');
					$('#datetimepicker .next').html('<i class="glyphicon glyphicon-arrow-right"></i>');
					common_date.showTimeSlider('as-now-time-slider','as_now_time');
					common_date.showCustomTimeSlider('custom-time-slider','custom_time');
					common_date.showTimeHourSlider('time-hour-slider');
					common_date.showTimeMinuteSilder('time-minute-slider');
					if($.cookie('current_time_flag') == 1) {
						$('#as_now_time_click_id').click();
					}
					if($.cookie('custom_time_flag') == 1) {
						$('#custom_time_click_id').click();
					}
					oDiv2.style.display='block';
					oDiv2.focus();
					$(oDiv1).find('.fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-up');
				}
				/**
				 * 时间确定按钮
				 */
				obtnSetPingButton.onclick=function()
				{
					$.cookie('current_time_flag',1,{path:'/'});
					$.cookie('custom_time_flag',0,{path:'/'});
					var result = common_date.drawCommonTimeRange();
					$('#set-ping-id').html(result.name);
					oDiv2.style.display='none';
					TSB.eventManager.trigger(event_enum.event_date);//执行事件队列
				};

				obtnSetButton.onclick=function()
				{
					// $("#set-ping-c").toggle();
					$.cookie('current_time_flag',0,{path:'/'});
					$.cookie('custom_time_flag',1,{path:'/'});
					oDiv2.style.display='none';
					$(oDiv1).find('.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
					var result = common_date.drawCommonTimeRange();
					$('#set-ping-id').html(result.name);
					TSB.eventManager.trigger(event_enum.event_date);//执行事件队列
				};

			};



			common_date.initTimeFun();

			//绑定ESC事件
			$(document).keydown(function(event){
				if($("#date-control").is(":visible")){
					if(event.keyCode == 27) $("#date-control").toggle();
				}
			});
			/**
			 * 时间确定按钮
			 */
			obtnSetPingButton.onclick=function()
			{
				$.cookie('current_time_flag',1,{path:'/'});
				$.cookie('custom_time_flag',0,{path:'/'});
				var result = common_date.drawCommonTimeRange();
				$('#set-ping-id').html(result.name);
				oDiv2.style.display='none';
				TSB.eventManager.trigger(event_enum.event_date);//执行事件队列
			};

			obtnSetButton.onclick=function()
			{
				// $("#set-ping-c").toggle();
				$.cookie('current_time_flag',0,{path:'/'});
				$.cookie('custom_time_flag',1,{path:'/'});
				oDiv2.style.display='none';
				$(oDiv1).find('.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
				var result = common_date.drawCommonTimeRange();
				$('#set-ping-id').html(result.name);
				TSB.eventManager.trigger(event_enum.event_date);//执行事件队列
			};

			if($.cookie('custom_time_flag')== 1) {
				$("#ping-time-s1").tab('show');
			}
			if($.cookie('custom_time_flag') != 1) {
				$('#as_now_time_click_id').click();
				var result = common_date.drawCommonTimeRange();
				$('#set-ping-id').html(result.name);
			}
			if($.cookie('current_time_flag') != 1) {
				$('#custom_time_click_id').click();
				var result = common_date.drawCommonTimeRange();
				$('#set-ping-id').html(result.name);
			}
			//创建当前滑块
			common_date.showTimeSlider('as-now-time-slider','as_now_time');
			//创建自定义滑块
			common_date.showCustomTimeSlider('as-custom-time-slider','custom_time');
			//创建自定义日期
			common_date.showDatePicker('datetimepicker');
			//创建自定义小时滑块
			common_date.showTimeHourSlider('time-hour-slider');
			//创建自定义分钟滑块
			common_date.showTimeMinuteSilder('time-minute-slider');

		});

	}

	//初始化时间控件
	initTimeControl(jQuery);

	module.exports = common_date;
});