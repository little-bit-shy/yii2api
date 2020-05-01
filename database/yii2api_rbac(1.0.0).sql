/*
 Navicat Premium Data Transfer

 Source Server         : 本地环境
 Source Server Type    : MySQL
 Source Server Version : 50645
 Source Host           : 192.168.177.177:3306
 Source Schema         : yii2api_rbac

 Target Server Type    : MySQL
 Target Server Version : 50645
 File Encoding         : 65001

 Date: 02/05/2020 02:37:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for y_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `y_auth_assignment`;
CREATE TABLE `y_auth_assignment`  (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  INDEX `auth_assignment_user_id_idx`(`user_id`) USING BTREE,
  CONSTRAINT `y_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `y_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'rbac' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of y_auth_assignment
-- ----------------------------
INSERT INTO `y_auth_assignment` VALUES ('root', '1', 1588152941);

-- ----------------------------
-- Table structure for y_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `y_auth_item`;
CREATE TABLE `y_auth_item`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  CONSTRAINT `y_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `y_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'rbac' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of y_auth_item
-- ----------------------------
INSERT INTO `y_auth_item` VALUES ('/*', 2, '全部', NULL, NULL, 1588151919, 1588358218);
INSERT INTO `y_auth_item` VALUES ('/account/*', 2, '账号中心', NULL, NULL, 1588330292, 1588330309);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/*', 2, '权限管理', NULL, NULL, 1588151920, 1588152138);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/add-permissions', 2, '添加权限', NULL, NULL, 1588151920, 1588152147);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/add-permissions-permissions', 2, '添加权限权限', NULL, NULL, 1588334002, 1588334809);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/add-role', 2, '添加角色', NULL, NULL, 1588151920, 1588152154);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/add-role-permissions', 2, '添加角色权限', NULL, NULL, 1588151920, 1588152191);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/add-role-role', 2, '添加角色角色', NULL, NULL, 1588151920, 1588152209);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/add-user', 2, '添加账号', NULL, NULL, 1588151920, 1588152227);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/add-user-role', 2, '添加账号角色', NULL, NULL, 1588151920, 1588152248);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/all-lists-with-level', 2, '全部权限列表数据（树状结构）', NULL, NULL, 1588151920, 1588331287);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/all-lists-with-permissions', 2, '权限所有权限列表', NULL, NULL, 1588332582, 1588332604);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/all-lists-with-role', 2, '角色所有权限列表', NULL, NULL, 1588151920, 1588152389);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/all-role-with-role', 2, '角色所有角色列表', NULL, NULL, 1588151920, 1588152403);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/all-role-with-user', 2, '账号所有角色列表', NULL, NULL, 1588151920, 1588152426);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/delete-permissions-permissions', 2, '删除权限权限', NULL, NULL, 1588334002, 1588334825);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/delete-role-permissions', 2, '删除角色权限', NULL, NULL, 1588151920, 1588152441);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/delete-role-role', 2, '删除角色角色', NULL, NULL, 1588151920, 1588152452);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/delete-user-role', 2, '删除账号角色', NULL, NULL, 1588151920, 1588152462);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/index', 2, '权限、角色列表数据', NULL, NULL, 1588151919, 1588152549);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/project-directory', 2, '项目所有操作', NULL, NULL, 1588151920, 1588152580);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/remove-permissions', 2, '删除权限', NULL, NULL, 1588151920, 1588152590);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/remove-role', 2, '删除角色', NULL, NULL, 1588239170, 1588239185);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/update-permissions', 2, '修改权限', NULL, NULL, 1588151920, 1588152626);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/update-role', 2, '修改角色', NULL, NULL, 1588238708, 1588238722);
INSERT INTO `y_auth_item` VALUES ('/account/auth-item/user-lists', 2, '账号列表', NULL, NULL, 1588151920, 1588152635);
INSERT INTO `y_auth_item` VALUES ('/account/site/*', 2, '基本操作', NULL, NULL, 1588151921, 1588152642);
INSERT INTO `y_auth_item` VALUES ('/account/site/all-permissions', 2, '账号所有权限', NULL, NULL, 1588151921, 1588152655);
INSERT INTO `y_auth_item` VALUES ('/account/site/captcha', 2, '获取验证码', NULL, NULL, 1588151920, 1588152667);
INSERT INTO `y_auth_item` VALUES ('/account/site/forget', 2, '忘记密码', NULL, NULL, 1588151921, 1588152676);
INSERT INTO `y_auth_item` VALUES ('/account/site/login', 2, '账号登录', NULL, NULL, 1588151921, 1588152711);
INSERT INTO `y_auth_item` VALUES ('/account/site/logout', 2, '账号登出', NULL, NULL, 1588151921, 1588152724);
INSERT INTO `y_auth_item` VALUES ('/account/site/registered', 2, '账号注册', NULL, NULL, 1588151921, 1588227650);
INSERT INTO `y_auth_item` VALUES ('/account/site/reset-psw', 2, '重置账号密码', NULL, NULL, 1588240513, 1588240523);
INSERT INTO `y_auth_item` VALUES ('/account/site/sms-code', 2, '发送手机验证码', NULL, NULL, 1588151921, 1588152754);
INSERT INTO `y_auth_item` VALUES ('/account/site/tenant-info', 2, '账号信息', NULL, NULL, 1588151921, 1588152764);
INSERT INTO `y_auth_item` VALUES ('/account/site/update', 2, '账号信息修改', NULL, NULL, 1588151921, 1588152778);
INSERT INTO `y_auth_item` VALUES ('ordinaryUser', 1, '普通用户', NULL, NULL, 1588152804, 1588331617);
INSERT INTO `y_auth_item` VALUES ('root', 1, '超级管理员', NULL, NULL, 1588152817, 1588331369);

-- ----------------------------
-- Table structure for y_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `y_auth_item_child`;
CREATE TABLE `y_auth_item_child`  (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `y_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `y_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `y_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `y_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'rbac' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of y_auth_item_child
-- ----------------------------
INSERT INTO `y_auth_item_child` VALUES ('root', '/*');
INSERT INTO `y_auth_item_child` VALUES ('/*', '/account/*');
INSERT INTO `y_auth_item_child` VALUES ('/account/*', '/account/auth-item/*');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/add-permissions');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/add-permissions-permissions');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/add-role');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/add-role-permissions');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/add-role-role');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/add-user');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/add-user-role');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/all-lists-with-level');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/all-lists-with-permissions');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/all-lists-with-role');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/all-role-with-role');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/all-role-with-user');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/delete-permissions-permissions');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/delete-role-permissions');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/delete-role-role');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/delete-user-role');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/index');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/project-directory');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/remove-permissions');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/remove-role');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/update-permissions');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/update-role');
INSERT INTO `y_auth_item_child` VALUES ('/account/auth-item/*', '/account/auth-item/user-lists');
INSERT INTO `y_auth_item_child` VALUES ('/account/*', '/account/site/*');
INSERT INTO `y_auth_item_child` VALUES ('ordinaryUser', '/account/site/*');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/all-permissions');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/captcha');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/forget');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/login');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/logout');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/registered');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/reset-psw');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/sms-code');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/tenant-info');
INSERT INTO `y_auth_item_child` VALUES ('/account/site/*', '/account/site/update');

-- ----------------------------
-- Table structure for y_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `y_auth_rule`;
CREATE TABLE `y_auth_rule`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'rbac' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
