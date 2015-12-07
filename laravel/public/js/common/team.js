/**
 * Created by bear on 14-7-19.
 */
/**
 * 修改团队成员
 * Created by bear on 14-6-25.
 */
 define(function (require, exports, module) {
	var team = function () {
		var $ = jQuery = require('jquery');
		var target_id = APPCONFIG.target_id;
		
		/**
		 * 初始化页面
		 */
		function init(target_type) {
			$(".col").each(function () {
				var oThis = $(this);
				var user_id = oThis.attr('js-data-user-id');
				remove(oThis, user_id,target_type);                                //绑定成员删除事件
				change(user_id,target_type);                                      //绑定成员修改事件
				addUser(target_type);
				ajaxLoadGroupUser(0);
			})
			$('#u1027_input').change(function(){
				team.ajaxLoadGroupUser($(this).val());
			});
		}

		/**
		 * 删除成员
		 * @param oThis
		 * @param user_id
		 * @param target_type
		 */
		function remove(oThis, user_id,target_type) {
			$('#de' + user_id).bind('click', function () {
				T.restPost(
					app_setting.ajax_remove_team_user,
					{user_id: user_id, target_id: target_id, target_type: target_type},
					function (back) {
						TSB.modalAlert({status: 'success', msg: back.msg});
						oThis.remove();
					},
					function (back) {
						TSB.modalAlert({status: 'error', msg: back.msg});
					}
				);
			})
		}

		/**
		 * 修改成员
		 * @param user_id
		 * @param target_type
		 */
		function change(user_id,target_type) {
			$('#fa' + user_id).bind('click', function () {
				var oB = $(this);
				if (oB.attr('class') == 'fa fa-play') {
					var action = 'play';
					var name = 'fa fa-pause';
					oB.parent().parent().attr('class','user_block grey');
				} else {
					var action = 'pause';
					var name = 'fa fa-play';
					oB.parent().parent().attr('class','user_block');
				}
				T.restPost(
					app_setting.ajax_modify_team_user,
					{user_id: user_id, target_id: target_id, action: action, target_type: target_type},
					function (back) {
						TSB.modalAlert({status: 'success', msg: back.msg});
						oB.removeClass().addClass(name);
					},
					function (back) {
						TSB.modalAlert({status: 'error', msg: back.msg});
					}
				);
			})
		}

		/**
		 * 添加成员
		 * @param target_type
		 */
		function addUser(target_type) {
			/********绑定拖拽事件********/
			$('.move', $('#side_list')).draggable({
				cancel: "a.ui-icon",
				revert: "invalid",
				containment: "document",
				helper: "clone",
				cursor: "move"
			});

			$('#user_list').droppable({
				accept: "#side_list .move",
				activeClass: "grey",
				drop: function (event, ui) {
					var user_id = ui.draggable.attr('value');
					if (!target_id || !user_id) return false;
					var get_api = app_setting.ajax_add_site_user;
					var postData = {};
					postData.user_id = user_id;
					postData.target_id = target_id;
					postData.target_type = target_type;
					T.restPost(get_api, postData,
						function (back) {
							console.log(back);
							TSB.modalAlert({status: 'success', msg: back.msg});
							var str = '';                                             //接收DOM字符串
							str += '<div class="col" js-data-user-id="' + back.data[0].user_id + '">';
							str += '<div class="user_block grey">';
							str += '<div class="user_handle"><i class="fa fa-pause" id="fa' + user_id + '"></i><i class="fa fa-times" id="de' + back.data[0].user_id + '"></i></div>';
							str += '<div class="user_head"><img src="/resource/img/admin/user_head.png" alt=""></div>';
							str += '<div class="user_name">' + back.data[0].user_name + '</div>';
							str += '<div class="user_name">' + back.data[0].group_name + '</div>';
							str += '<span class="user_mark"></span>';
							str += '</div></div>';
							$('#user_list').append(str);

							var oThis = $('div[js-data-user-id="' + back.data[0].user_id + '"]');
							change(user_id,target_type);                              //绑定成员修改事件
							remove(oThis, user_id,target_type);                        //绑定成员删除事件
						},
						function (black) {
							TSB.modalAlert({status: 'error', msg: black.msg});
						});
				}
			});
			/********绑定拖拽事件结束********/
		}

		/**
		 * 获取部门成员列表
		 */
		function ajaxLoadGroupUser(group_id) {
			T.restPost(
				app_setting.ajax_load_team_users,
				{group_id: group_id},
				function (data) {
					var element = '';
					if(data.data){
						$.each(data.data,function(k,v){
							console.log(v);
							element += '<li value="'+ v.user_id+'" class="move">'
									+'<label class="team-user-head"><a href="#"><img src="/resource/img/admin/user_head.png" height="30" width="30">'
									+'</a></label><label class="team-user-name"><a href="#">'+ v.user_name+'</a>'
									+'</label></li>';
						})
					}
					$('#side_list .move').remove();
					$('#side_list ul').append(element);
					/********绑定拖拽事件********/
					$('.move').draggable({
						cancel: "a.ui-icon",
						revert: "invalid",
						containment: "document",
						helper: "clone",
						cursor: "move"
					});
				},
				function () {
					$('#side_list .move').remove();
				}
			)
		}
		return {
			init: init,
			ajaxLoadGroupUser:ajaxLoadGroupUser
		}
	}();
	module.exports = team;
});