/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : exam_system

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-04-17 17:39:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tb_menues`
-- ----------------------------
DROP TABLE IF EXISTS `tb_menues`;
CREATE TABLE `tb_menues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '菜单名称',
  `url` varchar(255) DEFAULT NULL COMMENT '菜单路径',
  `pid` int(11) unsigned DEFAULT NULL COMMENT '菜单父id',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态，默认0可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_menues
-- ----------------------------
INSERT INTO `tb_menues` VALUES ('1', '系统管理', null, '3', '0');
INSERT INTO `tb_menues` VALUES ('2', '菜单管理', 'Menu/index', '1', '0');
INSERT INTO `tb_menues` VALUES ('3', '系统设置', null, '0', '0');
INSERT INTO `tb_menues` VALUES ('4', '事业', '', '0', '0');
INSERT INTO `tb_menues` VALUES ('5', '账户管理', 'Account/index', '1', '0');
INSERT INTO `tb_menues` VALUES ('6', '试卷管理', '', '4', '0');
INSERT INTO `tb_menues` VALUES ('7', '试卷列表', 'Paper/index', '6', '0');
INSERT INTO `tb_menues` VALUES ('8', '试题类型列表', 'Paper/question_type', '6', '0');
INSERT INTO `tb_menues` VALUES ('9', '试题列表', 'Paper/question_list', '6', '0');

-- ----------------------------
-- Table structure for `tb_papers`
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_papers
-- ----------------------------
INSERT INTO `tb_papers` VALUES ('1', '中考试题', '期中考试', '1523845803', '1523845809', '91', null, '0');

-- ----------------------------
-- Table structure for `tb_questions`
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
  `q_title` text COMMENT '试题题目',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_questions
-- ----------------------------
INSERT INTO `tb_questions` VALUES ('1', '1', '$_GET,$_POST', 'A,B', '5.0', '1523861483', null, '0', 'php中如何取得get，post参数，和上传的文件');

-- ----------------------------
-- Table structure for `tb_question_type`
-- ----------------------------
DROP TABLE IF EXISTS `tb_question_type`;
CREATE TABLE `tb_question_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `q_type_name` varchar(30) DEFAULT NULL COMMENT '试题类型名称',
  `q_type_dis` varchar(100) DEFAULT NULL COMMENT '试题类型描述',
  `q_type_addtime` int(11) unsigned DEFAULT NULL COMMENT '试题类型生成时间',
  `q_type_rule` varchar(100) DEFAULT NULL COMMENT '试题类型规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_question_type
-- ----------------------------
INSERT INTO `tb_question_type` VALUES ('1', '多选题', '', '1523845828', '多选');
INSERT INTO `tb_question_type` VALUES ('2', '单选题', '', '1523948155', '');
INSERT INTO `tb_question_type` VALUES ('3', '填空题', '', '1523948164', '');
INSERT INTO `tb_question_type` VALUES ('4', '简答题', '', '1523948216', '');

-- ----------------------------
-- Table structure for `tb_roles`
-- ----------------------------
DROP TABLE IF EXISTS `tb_roles`;
CREATE TABLE `tb_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '角色名',
  `rules` text COMMENT '权限',
  `des_info` varchar(100) DEFAULT NULL COMMENT '描述信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_roles
-- ----------------------------
INSERT INTO `tb_roles` VALUES ('1', 'admin', '1,2,3,4,5,6,7,8,9', null);
INSERT INTO `tb_roles` VALUES ('2', '学生', null, null);
INSERT INTO `tb_roles` VALUES ('3', '教师', '1,2,3,4,5,6,7,8,9', null);

-- ----------------------------
-- Table structure for `tb_users`
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_users
-- ----------------------------
INSERT INTO `tb_users` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '1523931811', '127.0.0.1', '0');
INSERT INTO `tb_users` VALUES ('2', 'study', 'e10adc3949ba59abbe56e057f20f883e', '张晓红', null, null, '0');
INSERT INTO `tb_users` VALUES ('4', 'study1', 'e10adc3949ba59abbe56e057f20f883e', 'study1', null, null, '0');
INSERT INTO `tb_users` VALUES ('5', 'study2', 'e10adc3949ba59abbe56e057f20f883e', 'study2', null, null, '0');
INSERT INTO `tb_users` VALUES ('6', 'study3', '33960aa2c4c89bba46feebd41baa4a72', 'study3', null, null, '0');
INSERT INTO `tb_users` VALUES ('7', 'study4', 'ed5e5ddcb587b44d58b68c76ce817516', 'study4', null, null, '0');
INSERT INTO `tb_users` VALUES ('8', 'study5', '722abe8dfae68abde2c23fa20582f72b', 'study5', null, null, '0');
INSERT INTO `tb_users` VALUES ('9', 'study6', 'c9728dc33e3d5a2f55cfa358cd03eec6', 'study6', null, null, '0');
INSERT INTO `tb_users` VALUES ('10', 'study7', '887c427840711265f2d6ff869b45f8bb', 'study7', null, null, '0');
INSERT INTO `tb_users` VALUES ('11', 'study8', '13ab3746ca0634b398a41a4e6fcbd24e', 'study8', null, null, '0');
INSERT INTO `tb_users` VALUES ('12', 'study9', 'a57f4f95c801bc52c8eed94e6ac7d1ce', 'study9', null, null, '0');

-- ----------------------------
-- Table structure for `tb_user_role_access`
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_role_access`;
CREATE TABLE `tb_user_role_access` (
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
  `role_id` int(11) unsigned DEFAULT NULL COMMENT '角色id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_user_role_access
-- ----------------------------
INSERT INTO `tb_user_role_access` VALUES ('1', '1');
INSERT INTO `tb_user_role_access` VALUES ('2', '2');
INSERT INTO `tb_user_role_access` VALUES ('4', '2');
INSERT INTO `tb_user_role_access` VALUES ('5', '2');
INSERT INTO `tb_user_role_access` VALUES ('6', '2');
INSERT INTO `tb_user_role_access` VALUES ('7', '1');
INSERT INTO `tb_user_role_access` VALUES ('8', '2');
INSERT INTO `tb_user_role_access` VALUES ('9', '2');
INSERT INTO `tb_user_role_access` VALUES ('10', '2');
INSERT INTO `tb_user_role_access` VALUES ('11', '2');
INSERT INTO `tb_user_role_access` VALUES ('12', '2');
