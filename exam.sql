/*
Navicat MySQL Data Transfer

Source Server         : test_local
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : exam

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-04-12 16:57:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_menues
-- ----------------------------
DROP TABLE IF EXISTS `tb_menues`;
CREATE TABLE `tb_menues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '菜单名称',
  `url` varchar(255) DEFAULT NULL COMMENT '菜单路径',
  `pid` int(11) unsigned DEFAULT NULL COMMENT '菜单父id',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态，默认0可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for tb_papers
-- ----------------------------
DROP TABLE IF EXISTS `tb_papers`;
CREATE TABLE `tb_papers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_name` varchar(100) DEFAULT NULL COMMENT '试卷名称或标题',
  `paper_ids` varchar(100) DEFAULT NULL COMMENT '试卷描述信息',
  `paper_addtime` int(11) unsigned DEFAULT NULL COMMENT '试卷生成时间',
  `paper_modifytime` int(11) unsigned DEFAULT NULL COMMENT '试卷修改时间',
  `exam_time` int(8) unsigned DEFAULT NULL COMMENT '考试限制时间',
  `paper_questions` text COMMENT '试卷试题',
  `is_del` tinyint(1) unsigned DEFAULT '0' COMMENT '试卷是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for tb_questions
-- ----------------------------
DROP TABLE IF EXISTS `tb_questions`;
CREATE TABLE `tb_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `q_type_id` int(11) DEFAULT NULL COMMENT '试题类型id',
  `q_content` text COMMENT '试题内容',
  `q_answer` text COMMENT '试题答案',
  `q_score` float(4,1) DEFAULT NULL COMMENT '试题分数',
  `q_addtime` int(11) unsigned DEFAULT NULL COMMENT '试题生成时间',
  `q_modifytime` int(11) unsigned DEFAULT NULL COMMENT '试题修改时间',
  `is_del` tinyint(1) unsigned DEFAULT '0' COMMENT '试题是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for tb_question_type
-- ----------------------------
DROP TABLE IF EXISTS `tb_question_type`;
CREATE TABLE `tb_question_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `q_type_name` varchar(30) DEFAULT NULL COMMENT '试题类型名称',
  `q_type_dis` varchar(100) DEFAULT NULL COMMENT '试题类型描述',
  `q_type_addtime` int(11) unsigned DEFAULT NULL COMMENT '试题类型生成时间',
  `q_type_rule` varchar(100) DEFAULT NULL COMMENT '试题类型规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for tb_roles
-- ----------------------------
DROP TABLE IF EXISTS `tb_roles`;
CREATE TABLE `tb_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '角色名',
  `rules` text COMMENT '权限',
  `des_info` varchar(100) DEFAULT NULL COMMENT '描述信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for tb_users
-- ----------------------------
DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(30) DEFAULT NULL COMMENT '账号',
  `pwd` char(32) DEFAULT NULL COMMENT '密码',
  `user_name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `login_time` int(11) unsigned DEFAULT NULL COMMENT '登录时间',
  `login_ip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  `is_del` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除，默认0正常',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for tb_user_role_access
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_role_access`;
CREATE TABLE `tb_user_role_access` (
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
  `role_id` int(11) unsigned DEFAULT NULL COMMENT '角色id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
