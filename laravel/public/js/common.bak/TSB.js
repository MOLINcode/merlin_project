/**
 * Created by neeke on 14-5-15.
 *
 * 前端组件库
 */
 define(function (require, exports, module) {
	var T;
    var TSB = require('TSB');
	T = (function ($, window, document, undefined) {

		var alert = function (msg, type,speed) {
			TSB.modalAlert({status: type ? type : 'success', msg: msg,speed:speed});
		};

		var restGet = function (url, data, success, error, type) {
			var der = $.Deferred();
			$.ajax({
				url: url,
				type: type || "get",
				data: data,
				dataType: "json",
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					//TODO 防止后台出现500等错误时出现"服务器错误弹窗"
					//TSB.modalAlert({status: 'danger', msg: lang_common.server_error});
				}
			}).done(function (data) {
					if (data && data.code === 1000) {
						if (typeof success === "function") {
							success.call(this, data);
						}
						der.resolve();
					}
					else {
						if (typeof error === 'function') {
							error.call(this, data);
						}
						der.reject(data);
					}
				}).fail(function () {

					der.reject();
				});
			return der.promise();
		};

		var restPost = function (url, data, success, error) {
			return T.restGet(url, data, success, error, "post");
		};

		var ajaxLoad = function (url, domId, data, callback) {
			data = (typeof data != 'undefined') ? data : {};
			var key, counter = 0;
			for (key in data) counter++;

			if (counter < 1) {
				$("#" + domId).load(url, function (response, status) {
					status = status.toLowerCase();
					if (status == 'success') {
						if (typeof callback != 'undefined') callback();
					}
					if (status == 'error') {

					}
				});
			} else {
				$("#" + domId).load(url, data, function (response, status, xhr) {
					status = status.toLowerCase();
					if (status == 'success') {
						if (typeof callback != 'undefined') callback();
					}
					if (status == 'error') {

					}
				});
			}
		}
		//获取对象中属性的个数
		var getObjCount = function (o) {
			var t = typeof o;
			if (t == 'string') {
				return o.length;
			} else if (t == 'object') {
				var n = 0;
				for (var i in o) {
					n++;
				}
				return n;
			}
			return false;
			};

		//显示loading
		var showLoading = function(domId){

			if(!$('#'+domId).data('reset')){
				//$('#'+domId).data('reset', $('#'+domId).html());
				if($('#'+domId)[0]!=undefined){
					$('#'+domId).data('reset', $('#'+domId)[0].outerHTML);
				}
			}
			if(!$('#'+domId).data('class')){
				$('#'+domId).data('class', $('#'+domId).attr('class'));
			}
			//divReset(domId);
			$('#'+domId).addClass('loading');
		}
		//无数据的样式
		var showNoData = function(domId){
			divReset(domId);
			$('#'+domId).addClass('nodata');
		}
		//重置
		var divReset = function(domId){
			var target = $('#'+domId);
			var parent = target.parent();
			var html = target.data('reset');
			target.remove();
			parent.append(html);
			$('#'+domId).attr('class',$('#'+domId).data('class'));
			/*$('#'+domId).html($('#'+domId).data('reset')).attr('class',$('#'+domId).data('class'));*/
		}

		var notFoundData = function(domId){
			var html = '<div class="basic-main-left-div dash top_15" style="padding:50px; border:1px dashed #ccc;"><div class="text-center"><img src="/resource/img/not_found.png"></div><div class="text-center font-18" style="font-size:18px; line-height:40px">哎呀，啥都没有发现，怎么回事?</div> <div class="text-center"> 如果有任何问题，请<a href="">查看帮助</a>或联系我们</div>';
			$('#'+domId).html(html);
		}
		return {
			restGet: restGet,
			restPost: restPost,
			alert: alert,
			ajaxLoad: ajaxLoad,
			getObjCount: getObjCount,
			showLoading:showLoading,
			showNoData:showNoData,
			divRest:divReset,
			notFoundData:notFoundData
		};
	})(jQuery, window, document, undefined);
	
	module.exports = T;
});