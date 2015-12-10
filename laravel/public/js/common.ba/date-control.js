/**
 * Created by admin-chen on 14-6-16.
 */
define(function (require, exports, module) {
	var $ = jQuery = require('jquery');
    require('jqueryCookie')($);
    require('dateTimePicker');
    var TSB = require('TSB');


	//扩展时间控件语言
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


	var dateController = function(){


		//初始化时间控件
		this.init = function(){

			this.datetime = new Date();

			this.end_time = 'now';

			this.time_step = $.cookie('time_step');


			if(!$.isNumeric(this.time_step)){
				//默认最近30分钟
				this.time_step = 1;
			}


			//初始化截止时间
			var str_time = $.cookie('end_time');
			var time = new Date(str_time);

			//判断是截止到当前还是自定义时间
			if(str_time == undefined || str_time == 'now' || time == 'Invalid Date' || time == NaN || time == 'NaN'){
				//默认截止到当前
				this.end_time = 'now';
				$('#dc-menu-now').click();
			}else{
				this.end_time = time;
				this.datetime = time;
				$('#dc-menu-custom').click();

			}


		};

		//显示时间段选择控件
		this.showTimeSlider = function(){
            var showMaxTime = parseInt($.trim($('#showMaxTimeId').val()));

			TSB.slider('#time-slider',{
				range: 'min',
				value:this.time_step,
				min: 1,
				max: showMaxTime,
				slideFun:function(event,ui){
					//提示文字
					$('#show-time-step-tip').html(lang_time.nearly+lang_time.format[ui.value]);
				}
			});
			$('#show-time-step-tip').html(lang_time.nearly+lang_time.format[this.time_step]);
		};

		this.showDatepicker = function(){
			var time = this.datetime;
			$('#datetimepicker').datetimepicker({
				weekStart: 1,
				language:lang_common.language,
				// todayBtn:  1,
				autoclose: 1,
				// todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0,
				//startDate:new Date(2014,5,12),
				endDate:new Date()
			}).on('changeDate',function(){

				var $date = $('#datetimepicker').data('datetimepicker');

				var tmpTime = $date.getDate();
				time.setFullYear(tmpTime.getFullYear());
				time.setMonth(tmpTime.getMonth());
				time.setDate(tmpTime.getDate());


				$('#show-custom-tip').html('('+lang_time.from+time.format('yyyy-MM-dd hh:mm')+')');


			});

			$('#datetimepicker').data('datetimepicker').setDate(time);

			//提示
			$('#show-custom-tip').html('('+lang_time.from+time.format('yyyy-MM-dd hh:mm')+')');


			//左右切换按钮
			$('#datetimepicker').find('table>thead>tr>th.next').html('<i class="glyphicon glyphicon-arrow-right"></i>');
			$('#datetimepicker').find('table>thead>tr>th.prev').html('<i class="glyphicon glyphicon-arrow-left"></i>');
		};

		this.showTimeHourSlider = function(){
			var time = this.datetime;
			$('#custom-slider-time span:first-of-type').html(time.format('hh'));
			TSB.slider('#time-hour-slider',{
				orientation: "vertical",
				range: 'min',
				value:time.getHours(),
				step:1,
				min: 0,
				max: 23,
				slideFun:function(event,ui){
					//提示
					time.setHours(ui.value);
					$('#custom-slider-time span:first-of-type').html(time.format('hh'));
					$('#show-custom-tip').html('(截止到'+time.format('yyyy-MM-dd hh:mm')+')');
				}
			});
		};

		/**
		 * 加载自定义分钟控件
		 * @param domId
		 */
		this.showTimeMinuteSilder = function(){
			var time = this.datetime;
			$('#custom-slider-time span:last-of-type').html(time.format('mm'));
			TSB.slider('#time-minute-slider',{
				orientation: "vertical",
				range: 'min',
				value:time.getMinutes(),
				min: 0,
				max: 59,
				slideFun:function(event,ui){
					//提示
					time.setMinutes(ui.value);

					$('#show-custom-tip').html('('+lang_time.from+time.format('yyyy-MM-dd hh:mm')+')');
					$('#custom-slider-time span:last-of-type').html(time.format('mm'));
				}
			});
		};

		//保存
		this.save = function(){

			var time_step = $('#time-slider').data('uiSlider').options.value;
			//设置时间段
			$.cookie('time_step',time_step,{path:"/"});

			var is_custom = $('#date-control .nav.nav-tediums>li.active a#dc-menu-custom').length > 0 ;

			var datetime = new Date();

			//设置结束时间
			if(is_custom == true){

				var date = new Date($('#datetimepicker').data('datetimepicker').getDate());
				var hours = $('#time-hour-slider').data('ui-slider').options.value;
				var minute = $('#time-minute-slider').data('ui-slider').options.value;
				date.setHours(hours);
				date.setMinutes(minute);
				date.setSeconds(0);
				$.cookie('end_time',date.format('yyyy/MM/dd hh:mm:ss'),{path:"/"});
				datetime = new Date($.cookie('end_time'));

			}else{

				$.cookie('end_time','now',{path:"/"});
			}

			//标题文字
			$('#date-title').html($('#show-time-step-tip').text()+'('+lang_time.from+':'+datetime.format('yyyy-MM-dd hh:mm')+')');

			TSB.eventManager.trigger(event_enum.event_date);//执行事件队列
		};


	};



	var dc = new dateController();



	//时间控件标题的点击事件
	$('#date-control>a[data-toggle="open"]').click(function(){
		$(this).parent('#date-control').toggleClass('open');
		if($(this).parent('#date-control').hasClass('open')){
            $(this).parent('#date-control').focus();
			dc.init();
			dc.showTimeSlider();
		}
	});

	//保存事件
	$('#date-control-save').click(function(){
		dc.save();
		$('#date-control').removeClass('open');
	});

	//取消事件
	$('#date-control [data-dismiss="modal"]').click(function(){
		$('#date-control').removeClass('open');
	});

	//显示截止到当前标签页
	$('#dc-menu-now').click(function(){
		$('#show-custom-tip').hide();
	});
	//显示自定义时间标签页
	$('#dc-menu-custom').click(function(){
		//时间提示
		$('#show-custom-tip').show();
		//显示日期选择控件
		dc.showDatepicker();
		//显示时间选择控件
		dc.showTimeHourSlider();
		dc.showTimeMinuteSilder();
	});

    var isFocus;
/*    $(document).delegate('.main_filter_time_content *','click',function(){
        isFocus = true;
        $('.main_filter_time_content').focus()

    });

    $('.main_filter_time_content').blur(function(){
        console.log(isFocus);
        if(!isFocus){
            console.log(11);
            $('#date-control').removeClass('open');
        }else{
            isFocus = false;
        }
    });*/

});