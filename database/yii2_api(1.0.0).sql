
-- ---------------
-- end_at字段无需用到，删除掉
-- ---------------
ALTER TABLE `ym_saas_account`.`ym_app`
DROP COLUMN `end_at`;

-- --------------
-- 删除account数据库的order表，该表无用到，进行删除
-- --------------
DROP TABLE `ym_saas_account`.`ym_order` ;


-- --------------
-- ym_tenant 修改，根据新需求增加需求字段
-- --------------
ALTER TABLE `ym_saas_account`.`ym_tenant`
ADD COLUMN `head` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '头像' AFTER `is_able`,
ADD COLUMN `sex` tinyint(1) UNSIGNED NOT NULL COMMENT '性别 1/男 2/女' AFTER `head`,
ADD COLUMN `province` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系地址 省' AFTER `sex`,
ADD COLUMN `city` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系地址 市' AFTER `province`,
ADD COLUMN `area` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系地址 区' AFTER `city`,
ADD COLUMN `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系地址 详细地址' AFTER `area`,
ADD COLUMN `phone` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系电话' AFTER `address`;

ALTER TABLE `ym_saas_account`.`ym_tenant`
  ADD COLUMN `qq` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'qq' AFTER `phone`;

-- --------------
-- ym_tenant 修改，性别默认可为空
-- --------------
ALTER TABLE `ym_saas_account`.`ym_tenant`
  MODIFY COLUMN `sex` tinyint(1) UNSIGNED NULL COMMENT '性别 1/男 2/女' AFTER `head`;

-- ----------------------------
-- ym_access_token access token 持久化记录
-- ----------------------------
DROP TABLE IF EXISTS `ym_access_token`;
CREATE TABLE `ym_access_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `access_token` char(64) NOT NULL COMMENT 'access token',
  `tenant_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `create_at` int(10) unsigned NOT NULL COMMENT '数据创建时间',
  `update_at` int(10) unsigned NOT NULL COMMENT '数据修改时间',
  `remove_at` int(10) unsigned NOT NULL COMMENT '令牌过期时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_token` (`access_token`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='access token 持久化记录';


-- ----------------------------
-- Table structure for ym_tenant_wx 用户微信信息
-- ----------------------------
DROP TABLE IF EXISTS `ym_tenant_wx`;
CREATE TABLE `ym_tenant_wx`  (
 `tenant_wx_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户微信信息id',
 `tenant_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
 `openid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户openid',
 `source` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '来源 1/校区端 2/学生端',
 `create_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '数据创建时间',
 `update_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '数据修改时间',
 PRIMARY KEY (`tenant_wx_id`) USING BTREE,
 INDEX `tenant_id`(`tenant_id`) USING BTREE,
 INDEX `openid`(`openid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户微信信息' ROW_FORMAT = Dynamic;


-- ----------------------------
-- ym_tenant 用户表添加索引
-- ----------------------------
ALTER TABLE `ym_saas_account`.`ym_tenant`
  ADD INDEX `account`(`account`) USING BTREE;

ALTER TABLE `ym_saas_account`.`ym_tenant`
  ADD INDEX `create_at`(`create_at`) USING BTREE;

-- ----------------------------
-- ym_app 应用信息添加索引
-- ----------------------------
ALTER TABLE `ym_saas_account`.`ym_app`
  ADD INDEX `app_name`(`app_name`) USING BTREE,
  ADD INDEX `app_cat_id`(`app_cat_id`) USING BTREE,
  ADD INDEX `create_at`(`create_at`) USING BTREE;

ALTER TABLE `ym_saas_account`.`ym_app`
DROP INDEX `own_tenant_id`,
ADD INDEX `own_tenant_id`(`own_tenant_id`) USING BTREE;

-- ----------------------------
-- ym_tenant_wx 用户微信信息表添加索引
-- ----------------------------
ALTER TABLE `ym_saas_account`.`ym_tenant_wx`
  ADD INDEX `source`(`source`) USING BTREE,
  ADD INDEX `create_at`(`create_at`) USING BTREE;
