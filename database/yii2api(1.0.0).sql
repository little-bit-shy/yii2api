/*
 Navicat Premium Data Transfer

 Source Server         : 本地开发
 Source Server Type    : MySQL
 Source Server Version : 50728
 Source Host           : 192.168.1.123:3306
 Source Schema         : yii2api

 Target Server Type    : MySQL
 Target Server Version : 50728
 File Encoding         : 65001

 Date: 30/04/2020 09:35:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for y_access_token
-- ----------------------------
DROP TABLE IF EXISTS `y_access_token`;
CREATE TABLE `y_access_token`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `access_token` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'access token',
  `tenant_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  `create_at` int(10) UNSIGNED NOT NULL COMMENT '数据创建时间',
  `update_at` int(10) UNSIGNED NOT NULL COMMENT '数据修改时间',
  `remove_at` int(10) UNSIGNED NOT NULL COMMENT '令牌过期时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `access_token`(`access_token`) USING BTREE,
  INDEX `tenant_id`(`tenant_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'access token 持久化记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of y_access_token
-- ----------------------------

-- ----------------------------
-- Table structure for y_log
-- ----------------------------
DROP TABLE IF EXISTS `y_log`;
CREATE TABLE `y_log`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level` int(11) NULL DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `log_time` double NULL DEFAULT NULL,
  `prefix` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `message` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_log_level`(`level`) USING BTREE,
  INDEX `idx_log_category`(`category`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of y_log
-- ----------------------------

-- ----------------------------
-- Table structure for y_tenant
-- ----------------------------
DROP TABLE IF EXISTS `y_tenant`;
CREATE TABLE `y_tenant`  (
  `tenant_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `account` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `mobile` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `password` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `create_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '数据创建时间',
  `update_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '数据修改时间',
  `is_able` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '启用状态 2/禁用 1/启用',
  `head` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '头像',
  `sex` tinyint(1) UNSIGNED NULL DEFAULT NULL COMMENT '性别 1/男 2/女',
  `province` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系地址 省',
  `city` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系地址 市',
  `area` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系地址 区',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系地址 详细地址',
  `phone` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系电话',
  `qq` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'qq',
  PRIMARY KEY (`tenant_id`) USING BTREE,
  UNIQUE INDEX `mobile`(`mobile`) USING BTREE,
  INDEX `account`(`account`) USING BTREE,
  INDEX `create_at`(`create_at`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户信息' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of y_tenant
-- ----------------------------
INSERT INTO `y_tenant` VALUES (1, '你猜', '15918793994', '$2y$13$TYE5wbUNWhQ8Z.Wr.z2i4.54TeZQGFt9DwKkdbF.9KwzCDI3PGWni', 1567761749, 1588153000, 1, NULL, 1, '', '', '', '', '', '');

SET FOREIGN_KEY_CHECKS = 1;
