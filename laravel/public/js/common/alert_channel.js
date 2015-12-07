/**
 * Created by bear on 14-6-27.
 */
define(function (require, exports, module) {

	var alert_channel = function(jQuery){
		return (function ($) {

			/**
			 * 初始化页面
			 */
			function init(target_type) {
				bindWarningStatus(target_type);
				getUserList(target_type);
				bindWarningSizeStatus(target_type);
			}


			/**
			 * 单个用户报警设置
			 */
			function bindWarningStatus(target_type) {
				$(document).delegate(':checkbox[class^="single"]', 'click', function () {
					var user_id = $(this).val();
					var target_id = APPCONFIG.target_id;
					var status_class = $(this).attr('class');
					var type = null;

					switch (status_class) {
						case 'single1':
							type = app_enum.alert_config_type_warning;
							break;
						case 'single2':
							type = app_enum.alert_config_type_error;
							break;
						case 'single3':
							type = app_enum.alert_config_type_message;
							break;
						case 'single4':
							type = app_enum.alert_config_type_email;
							break;
					}

					T.restPost(
						app_setting.ajax_modify_alert_status,
						{target_id: target_id, user_id: user_id, type: type, target_type: target_type},
						function (back) {
							TSB.modalAlert({status: 'success', msg: back.msg});
						},
						function (back) {
							TSB.modalAlert({status: 'error', msg: back.msg});
						}
					)
				})
			}

			/**
			 * 获取部门成员列表
			 */
			function getUserList(target_type) {
				$('li[name="list"]').click(function () {

					var group_id = $(this).val();
					var target_id = APPCONFIG.target_id;

					function ifChecked(status) {
						return status == app_enum.alert_config_alarm_normal ? "checked='checked'" : "";
					}

					T.restPost(
						app_setting.ajax_get_group_user,
						{group_id: group_id, target_id: target_id,target_type:target_type},
						function (back) {
							$(':checkbox[class^="all"]').val(group_id);
							var str = '';
							$.each(back.data, function (k, user) {
								str += '<tr><td class="text-left">' + user.user_name + ' </td>';
								str += '<td class="text-left"> ' + user.user_email + '  </td>';
								str += '<td class="text-left"><span class="user_mark admin_user"></span>' + user.role_name + '</td>';
								str += '<td class="text-left">'+user.group_name+'</td>';
								str += '<td class="text-left"><input ' + ifChecked(user.warning_type) + ' type="checkbox" class="single1" value="' + user.user_id + '"></td>';
								str += '<td class="text-left"><input ' + ifChecked(user.error_type) + ' type="checkbox" class="single2" value="' + user.user_id + '"></td>';
								str += '<td class="text-left"><input ' + ifChecked(user.message_alarm) + ' type="checkbox" class="single3" value="' + user.user_id + '">';
								if(user.user_status != 2){
									str += '<i class="fa fa-exclamation-triangle" title="尚未激活"></i>';
								}
								str += '</td><td class="text-left"><input ' + ifChecked(user.mail_alarm) + ' type="checkbox" class="single4" value="' + user.user_id + '">';
								if(user.mobile_auth != 1){
									str += '<i class="fa fa-exclamation-triangle" title="尚未激活"></i>';
								}
								str += '</td></tr>';
							});

							$('#userlist').empty().append(str);
						},
						function (back) {
							$('#userlist').empty().append('尚未添加部门成员');
						}
					)
				});

			}

			/**
			 * 批量修改报警设置
			 * @type {alert_config_alarm_stop|*}
			 */
			function bindWarningSizeStatus(target_type) {

				$(document).delegate(':checkbox[class^="all"]', 'click', function () {

					var group_id = $(this).val();
					var target_id = APPCONFIG.target_id;
					var status_class = $(this).attr('class');
					var type = null;
					var status = $(this).prop('checked');

					if (status) {
						status = 1;
					} else {
						status = 0;
					}

					switch (status_class) {
						case 'all1':
							type = app_enum.alert_config_type_warning;
							break;
						case 'all2':
							type = app_enum.alert_config_type_error;
							break;
						case 'all3':
							type = app_enum.alert_config_type_message;
							break;
						case 'all4':
							type = app_enum.alert_config_type_email;
							break;
					}

					T.restPost(

						app_setting.ajax_modify_size_status,

						{target_id: target_id, group_id: group_id, type: type, status: status, target_type: target_type},

						function (back) {
							TSB.modalAlert({status: 'success', msg: back.msg});

							if (back.data.status) {
								$('.single' + type).prop('checked', status);
							} else {
								$('.single' + type).prop('checked', status);
							}
						},

						function (back) {
							TSB.modalAlert({status: 'error', msg: back.msg});
						}
					)
				})
			}

			return {
				init: init
			}
		})(jQuery);
	}
	module.exports = alert_channel;
});