/*
Navicat MySQL Data Transfer

Source Server         : myubuntu
Source Server Version : 50544
Source Host           : 10.0.5.173:3306
Source Database       : laraTest

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2015-11-25 20:08:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `user_info`
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `user_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1可用  2 不可用 ',
  `user_ticket` varchar(32) DEFAULT NULL,
  `login_time` int(11) NOT NULL DEFAULT '0',
  `last_login_time` int(11) NOT NULL DEFAULT '0',
  `role` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 只读用户 2 高级用户 3管理员',
  `portrait` varchar(255) DEFAULT NULL COMMENT '头像',
  `credits` int(10) DEFAULT NULL COMMENT '积分',
  `group_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `index_email` (`user_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_info
-- ----------------------------

-- ----------------------------
-- Table structure for `user_register`
-- ----------------------------
DROP TABLE IF EXISTS `user_register`;
CREATE TABLE `user_register` (
  `register_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(32) NOT NULL,
  `user_name` varchar(32) NOT NULL,
  `register_time` int(11) NOT NULL,
  `register_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:等待审核\n2:审核通过\n3:审核失败',
  `relationship_user` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`register_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_register
-- ----------------------------
