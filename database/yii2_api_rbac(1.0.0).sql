/*
Navicat MySQL Data Transfer

Source Server         : 本地开发
Source Server Version : 50728
Source Host           : 192.168.1.123:3306
Source Database       : ym_saas_account

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2019-12-23 17:37:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `ym_auth_assignment`;
CREATE TABLE `ym_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`) USING BTREE,
  KEY `auth_assignment_user_id_idx` (`user_id`) USING BTREE,
  CONSTRAINT `ym_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `ym_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='rbac';

-- ----------------------------
-- Records of ym_auth_assignment
-- ----------------------------
INSERT INTO `ym_auth_assignment` VALUES ('root', '1', '1569480246');

-- ----------------------------
-- Table structure for ym_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `ym_auth_item`;
CREATE TABLE `ym_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  KEY `rule_name` (`rule_name`) USING BTREE,
  KEY `type` (`type`) USING BTREE,
  CONSTRAINT `ym_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `ym_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='rbac';

-- ----------------------------
-- Records of ym_auth_item
-- ----------------------------
INSERT INTO `ym_auth_item` VALUES ('/*', '2', '所有', null, null, '1569463444', '1574308168');
INSERT INTO `ym_auth_item` VALUES ('/account/*', '2', '个人中心', null, null, '1567762398', '1567839022');
INSERT INTO `ym_auth_item` VALUES ('/account/app/*', '2', '应用中心', null, null, '1570591590', '1570591673');
INSERT INTO `ym_auth_item` VALUES ('/account/app/app-cat-listing', '2', '分类列表', null, null, '1570591590', '1570591686');
INSERT INTO `ym_auth_item` VALUES ('/account/app/app-create', '2', '应用创建', null, null, '1570591591', '1570591711');
INSERT INTO `ym_auth_item` VALUES ('/account/app/app-listing', '2', '授权应用列表', null, null, '1570601136', '1570601154');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/*', '2', '权限管理', null, null, '1567762397', '1567839038');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/add-permissions', '2', '添加权限', null, null, '1567762395', '1567839050');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/add-role', '2', '添加角色', null, null, '1567762396', '1567839063');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/add-role-permissions', '2', '添加角色权限', null, null, '1567762396', '1574650370');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/add-role-role', '2', '添加角色子角色', null, null, '1569404317', '1569404349');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/add-user', '2', '添加用户', null, null, '1567762397', '1567839097');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/add-user-role', '2', '添加用户角色', null, null, '1567762397', '1567839120');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/all-lists', '2', '所有权限', null, null, '1567762395', '1567839500');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/all-lists-with-level', '2', '权限列表（分级）', null, null, '1567762396', '1567839179');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/all-lists-with-role', '2', '角色列表', null, null, '1567762396', '1567839196');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/all-role-with-role', '2', '获取角色子角色', null, null, '1569404318', '1569404362');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/all-role-with-user', '2', '用户角色列表', null, null, '1567762397', '1567839223');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/delete-role-permissions', '2', '删除角色权限', null, null, '1567762396', '1567839241');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/delete-role-role', '2', '删除角色子角色', null, null, '1569404317', '1569404391');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/delete-user-role', '2', '删除用户角色', null, null, '1567762397', '1567839253');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/index', '2', '权限列表', null, null, '1567762395', '1567839494');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/project-directory', '2', '项目操作列表', null, null, '1567762395', '1567839367');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/remove-permissions', '2', '删除权限', null, null, '1567762396', '1567839376');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/reset-psw-user', '2', '密码重置', null, null, '1567762397', '1567839386');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/update-permissions', '2', '修改权限', null, null, '1567762396', '1567839393');
INSERT INTO `ym_auth_item` VALUES ('/account/auth-item/user-lists', '2', '用户列表', null, null, '1567762397', '1567839400');
INSERT INTO `ym_auth_item` VALUES ('/account/default/*', '2', '登陆相关', null, null, '1567762398', '1567839558');
INSERT INTO `ym_auth_item` VALUES ('/account/default/all-permissions', '2', '用户权限列表', null, null, '1567762398', '1567839429');
INSERT INTO `ym_auth_item` VALUES ('/account/default/captcha', '2', '验证码', null, null, '1567762397', '1567839440');
INSERT INTO `ym_auth_item` VALUES ('/account/default/forget', '2', '重置密码', null, null, '1574909654', '1574909683');
INSERT INTO `ym_auth_item` VALUES ('/account/default/login', '2', '用户登陆', null, null, '1567762398', '1567839448');
INSERT INTO `ym_auth_item` VALUES ('/account/default/logout', '2', '用户登出', null, null, '1567762398', '1567839457');
INSERT INTO `ym_auth_item` VALUES ('/account/default/registered', '2', '用户注册', null, null, '1570609169', '1570609194');
INSERT INTO `ym_auth_item` VALUES ('/account/default/sms-code', '2', '验证码发送', null, null, '1568017668', '1568017687');
INSERT INTO `ym_auth_item` VALUES ('/account/default/tenant-info', '2', '获取个人信息', null, null, '1568017668', '1568017701');
INSERT INTO `ym_auth_item` VALUES ('/account/default/update', '2', '修改个人信息', null, null, '1576200928', '1576200950');
INSERT INTO `ym_auth_item` VALUES ('/crm/*', '2', 'CRM', null, null, '1576201080', '1576201102');
INSERT INTO `ym_auth_item` VALUES ('/crm/app/*', '2', '应用管理', null, null, '1576201074', '1576201114');
INSERT INTO `ym_auth_item` VALUES ('/crm/app/list', '2', '应用列表', null, null, '1576201074', '1576201122');
INSERT INTO `ym_auth_item` VALUES ('/crm/campus/*', '2', '校区管理', null, null, '1576201080', '1576201132');
INSERT INTO `ym_auth_item` VALUES ('/crm/campus/list', '2', '校区列表', null, null, '1576201074', '1576201141');
INSERT INTO `ym_auth_item` VALUES ('/crm/campus/update', '2', '校区更新', null, null, '1576201080', '1576201154');
INSERT INTO `ym_auth_item` VALUES ('/crm/feedback/*', '2', '反馈管理', null, null, '1576201074', '1576201165');
INSERT INTO `ym_auth_item` VALUES ('/crm/feedback/list', '2', '反馈列表', null, null, '1576201074', '1576201179');
INSERT INTO `ym_auth_item` VALUES ('/crm/order/*', '2', '订单管理', null, null, '1576201080', '1576201188');
INSERT INTO `ym_auth_item` VALUES ('/crm/order/list', '2', '订单列表', null, null, '1576201075', '1576201199');
INSERT INTO `ym_auth_item` VALUES ('/crm/order/update', '2', '订单更新', null, null, '1576201075', '1576201211');
INSERT INTO `ym_auth_item` VALUES ('/crm/package/*', '2', '套餐管理', null, null, '1576201075', '1576201286');
INSERT INTO `ym_auth_item` VALUES ('/crm/package/list', '2', '套餐列表', null, null, '1576201080', '1576201295');
INSERT INTO `ym_auth_item` VALUES ('/crm/rbac/*', '2', '权限管理', null, null, '1577065788', '1577065814');
INSERT INTO `ym_auth_item` VALUES ('/crm/rbac/my-roles', '2', '我的权限', null, null, '1577065788', '1577065823');
INSERT INTO `ym_auth_item` VALUES ('/crm/tenant/*', '2', '用户管理', null, null, '1576201080', '1576201305');
INSERT INTO `ym_auth_item` VALUES ('/crm/tenant/list', '2', '用户列表', null, null, '1576201075', '1576201313');
INSERT INTO `ym_auth_item` VALUES ('/edu/*', '2', '教育系统', null, null, '1569552618', '1569552659');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/*', '2', '校区管理', null, null, '1569811146', '1569811168');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/all-permissions', '2', '对应校区用户拥有的权限', null, null, '1573524937', '1573616486');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/campus-renewal', '2', '校区续费（下单）', null, null, '1575945553', '1575950169');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/create', '2', '校区创建', null, null, '1569811145', '1569811204');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/deduct-course-list', '2', '消课排行-按课程', null, null, '1573450753', '1573789473');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/deduct-employees-list', '2', '消课排行-按教师', null, null, '1573450748', '1573789487');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/list', '2', '校区列表', null, null, '1570609169', '1570609206');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/myself', '2', '我的校区', null, null, '1569811145', '1569811212');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/price-count', '2', '本月实收', null, null, '1573198299', '1573457332');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/refund-count', '2', '退费金额走势', null, null, '1573782399', '1573789502');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/refund-sum', '2', '本月学员退费统计', null, null, '1577090072', '1577090205');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/resources-count', '2', '本月新增学员统计', null, null, '1573198298', '1573789574');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/resources-deduct-count', '2', '本月消课课时统计', null, null, '1573198298', '1573789616');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/resources-deduct-list', '2', '本月消课统计', null, null, '1573782399', '1573789644');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/resources-sign-count', '2', '本月出勤统计', null, null, '1573198298', '1573789656');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/total-count', '2', '总金额走势', null, null, '1573782399', '1573789670');
INSERT INTO `ym_auth_item` VALUES ('/edu/campus/update', '2', '修改校区', null, null, '1571818776', '1571818794');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling-students/*', '2', '课节学生管理', null, null, '1572932535', '1572932571');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling-students/change-classes', '2', '学生调课', null, null, '1572932535', '1572932585');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling-students/class-students', '2', '学生班级列表', null, null, '1572932535', '1572932609');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling-students/create', '2', '添加课节学生', null, null, '1572932543', '1572932619');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling-students/delete', '2', '课节学生删除', null, null, '1572932543', '1572932633');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling-students/lists', '2', '课节学生列表', null, null, '1572932543', '1572932642');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling-students/sign', '2', '课节学生签到', null, null, '1572932543', '1572932653');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/*', '2', '排课管理', null, null, '1572240150', '1572240171');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/all-date-group', '2', '课表-日期段分组', null, null, '1573524937', '1573616339');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/all-time-group', '2', '课表-小时段分组', null, null, '1573524937', '1573616333');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/change-classes', '2', '教师调课', null, null, '1572932543', '1572932666');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/classroom-group', '2', '课表-教室段分组', null, null, '1573524938', '1573616327');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/conclusion', '2', '课节完结', null, null, '1572932543', '1572932685');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/count-class-students', '2', '总班课数&总排课学生数', null, null, '1573198304', '1573198400');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/create', '2', '添加排课', null, null, '1572240150', '1572240179');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/current', '2', '最近的排课数据（对应教师）', null, null, '1577089747', '1577089808');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/current-all', '2', '最近的排课数据', null, null, '1577090107', '1577090148');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/deduct-hour', '2', '本月消课统计（对应教师）', null, null, '1577089747', '1577089822');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/deduct-hour-all', '2', '本月消课统计', null, null, '1577090553', '1577090572');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/delete', '2', '课节删除', null, null, '1572932534', '1572932700');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/employees-group', '2', '课表-教师段分组', null, null, '1573524938', '1573616100');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/list-date', '2', '排课列表（按日期分组）', null, null, '1572932534', '1572932719');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/list-date-employees', '2', '考勤课表-班课课程列表数据（登录系统教师数据）', null, null, '1573198304', '1573629574');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/list-date-employees-days', '2', '考勤课表-日期段分组（登录系统教师数据）', null, null, '1573524941', '1573629634');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/list-date-employees-time', '2', '考勤课表-小时段分组（登录系统教师数据）', null, null, '1573524938', '1573629604');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/lists', '2', '排课列表', null, null, '1572932534', '1572932727');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/lists-employees', '2', '考勤列表-班课课程列表数据（登录系统教师数据）', null, null, '1573198299', '1573629536');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/month-endcount', '2', '每月的消课数(对应教师)', null, null, '1577089747', '1577089853');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/month-endcount-all', '2', '每月的消课数', null, null, '1577090082', '1577090176');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/scheduling-classroom-days', '2', '课表-班课课程列表数据-教室段分组', null, null, '1573624041', '1573625378');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/scheduling-employees-days', '2', '课表-班课课程列表数据-教师段分组', null, null, '1573624041', '1573625399');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-scheduling/scheduling-list', '2', '课表-班课课程列表数据-日期段分组', null, null, '1573524937', '1573625349');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-students/*', '2', '班课过滤学生管理', null, null, '1571886034', '1571886056');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-students/create', '2', '添加班课过滤学生', null, null, '1571886034', '1571886068');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-students/delete', '2', '删除班课过滤学生', null, null, '1571886034', '1571886076');
INSERT INTO `ym_auth_item` VALUES ('/edu/class-students/lists', '2', '班课过滤学生列表', null, null, '1571886034', '1571886088');
INSERT INTO `ym_auth_item` VALUES ('/edu/class/*', '2', '班课管理', null, null, '1571280649', '1571280668');
INSERT INTO `ym_auth_item` VALUES ('/edu/class/create', '2', '添加班课', null, null, '1571280649', '1571280680');
INSERT INTO `ym_auth_item` VALUES ('/edu/class/deduct', '2', '班级、教师消课统计', null, null, '1573198299', '1573450794');
INSERT INTO `ym_auth_item` VALUES ('/edu/class/deduct-students', '2', '学员消课统计', null, null, '1573198299', '1573454553');
INSERT INTO `ym_auth_item` VALUES ('/edu/class/delete', '2', '班课删除', null, null, '1572932534', '1572932738');
INSERT INTO `ym_auth_item` VALUES ('/edu/class/end', '2', '班课完结', null, null, '1572932534', '1572932746');
INSERT INTO `ym_auth_item` VALUES ('/edu/class/list', '2', '班课列表', null, null, '1571291746', '1571291764');
INSERT INTO `ym_auth_item` VALUES ('/edu/class/update', '2', '修改班课', null, null, '1571382954', '1571382967');
INSERT INTO `ym_auth_item` VALUES ('/edu/classroom/*', '2', '教室管理', null, null, '1571019758', '1571019773');
INSERT INTO `ym_auth_item` VALUES ('/edu/classroom/create', '2', '添加教室', null, null, '1571020848', '1571020869');
INSERT INTO `ym_auth_item` VALUES ('/edu/classroom/list', '2', '教室列表', null, null, '1571019758', '1571019781');
INSERT INTO `ym_auth_item` VALUES ('/edu/classroom/update', '2', '修改教室', null, null, '1571021306', '1571021320');
INSERT INTO `ym_auth_item` VALUES ('/edu/course/*', '2', '课程管理', null, null, '1570871239', '1570871256');
INSERT INTO `ym_auth_item` VALUES ('/edu/course/create', '2', '添加课程', null, null, '1570871239', '1570871267');
INSERT INTO `ym_auth_item` VALUES ('/edu/course/list', '2', '课程列表', null, null, '1570872706', '1570872720');
INSERT INTO `ym_auth_item` VALUES ('/edu/course/update', '2', '修改课程', null, null, '1570871474', '1570871496');
INSERT INTO `ym_auth_item` VALUES ('/edu/default/*', '2', '初始化', null, null, '1569552618', '1569552705');
INSERT INTO `ym_auth_item` VALUES ('/edu/default/all-permissions', '2', '用户已有权限', null, null, '1569552618', '1569552735');
INSERT INTO `ym_auth_item` VALUES ('/edu/employees/*', '2', '员工管理', null, null, '1569811145', '1569811222');
INSERT INTO `ym_auth_item` VALUES ('/edu/employees/create', '2', '员工添加', null, null, '1569812256', '1569812275');
INSERT INTO `ym_auth_item` VALUES ('/edu/employees/list', '2', '员工列表', null, null, '1569811146', '1569811232');
INSERT INTO `ym_auth_item` VALUES ('/edu/employees/update', '2', '员工修改', null, null, '1569822689', '1569822710');
INSERT INTO `ym_auth_item` VALUES ('/edu/feedback/*', '2', '用户反馈', null, null, '1576200978', '1576201000');
INSERT INTO `ym_auth_item` VALUES ('/edu/feedback/create', '2', '添加反馈', null, null, '1576200978', '1576201010');
INSERT INTO `ym_auth_item` VALUES ('/edu/feedback/delete', '2', '删除反馈', null, null, '1576200978', '1576201018');
INSERT INTO `ym_auth_item` VALUES ('/edu/feedback/list', '2', '反馈列表', null, null, '1576200978', '1576201026');
INSERT INTO `ym_auth_item` VALUES ('/edu/file/*', '2', '文件管理', null, null, '1569811146', '1569811241');
INSERT INTO `ym_auth_item` VALUES ('/edu/file/upload', '2', '文件上传', null, null, '1569811146', '1569811249');
INSERT INTO `ym_auth_item` VALUES ('/edu/order/*', '2', '订单中心', null, null, '1575945553', '1575945606');
INSERT INTO `ym_auth_item` VALUES ('/edu/order/list', '2', '订单列表', null, null, '1575945553', '1575945614');
INSERT INTO `ym_auth_item` VALUES ('/edu/order/update', '2', '取消订单', null, null, '1575945553', '1575945625');
INSERT INTO `ym_auth_item` VALUES ('/edu/package/*', '2', '校区套餐', null, null, '1575945559', '1575945655');
INSERT INTO `ym_auth_item` VALUES ('/edu/package/list', '2', '套餐列表', null, null, '1575945553', '1575948434');
INSERT INTO `ym_auth_item` VALUES ('/edu/pay/*', '2', '订单支付', null, null, '1575945559', '1575950358');
INSERT INTO `ym_auth_item` VALUES ('/edu/pay/aop-renewal', '2', '校区续费（支付宝支付）', null, null, '1575945554', '1575950459');
INSERT INTO `ym_auth_item` VALUES ('/edu/pay/aop-renewal-notify', '2', '校区续费（支付宝异步通知）', null, null, '1575945554', '1575950453');
INSERT INTO `ym_auth_item` VALUES ('/edu/pay/wxp-renewal', '2', '校区续费（微信支付）', null, null, '1575945554', '1575950448');
INSERT INTO `ym_auth_item` VALUES ('/edu/pay/wxp-renewal-notify', '2', '校区续费（微信异步通知）', null, null, '1575945559', '1575950444');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-course/*', '2', '学生资源课程', null, null, '1571046522', '1571046556');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-course/count', '2', '学生资源购课统计', null, null, '1573198304', '1573442823');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-course/create', '2', '添加学生资源课程', null, null, '1571046522', '1571046565');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-course/delete', '2', '删除学生资源课程', null, null, '1572932547', '1572932761');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-course/list', '2', '学生资源课程列表', null, null, '1571120526', '1571120546');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-course/refund', '2', '退款学生资源课程', null, null, '1572932547', '1572932789');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-course/update', '2', '修改学生资源课程', null, null, '1571118560', '1571118582');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-follow/*', '2', '资源跟进', null, null, '1570848634', '1570848647');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-follow/create', '2', '添加资源跟进', null, null, '1570848634', '1570848663');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-follow/delete', '2', '删除资源跟进', null, null, '1572932547', '1572932801');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-follow/list', '2', '资源跟进列表', null, null, '1570851277', '1570851293');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources-follow/update', '2', '修改资源跟进', null, null, '1572932547', '1572932824');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources/*', '2', '学生资源', null, null, '1570678047', '1570678071');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources/compute', '2', '学员统计（对应销售）', null, null, '1577089556', '1577089588');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources/create', '2', '添加资源', null, null, '1570678053', '1570678084');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources/list', '2', '资源列表（对应用户）', null, null, '1570760253', '1570760285');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources/list-all', '2', '资源列表（所有用户）', null, null, '1570762484', '1570762501');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources/month-count', '2', '学员每月新增统计（对应销售）', null, null, '1577089556', '1577089604');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources/transfer', '2', '转让资源', null, null, '1570783851', '1570783873');
INSERT INTO `ym_auth_item` VALUES ('/edu/resources/update', '2', '修改资源', null, null, '1570688183', '1570688197');
INSERT INTO `ym_auth_item` VALUES ('/resources/*', '2', '学生端', null, null, '1577090642', '1577090676');
INSERT INTO `ym_auth_item` VALUES ('/resources/class-scheduling-students/*', '2', '班课课节', null, null, '1577090642', '1577090696');
INSERT INTO `ym_auth_item` VALUES ('/resources/class-scheduling-students/class-list', '2', '学员所在班级', null, null, '1577090635', '1577090924');
INSERT INTO `ym_auth_item` VALUES ('/resources/class-scheduling-students/list-course', '2', '学员排课课表', null, null, '1577090634', '1577090871');
INSERT INTO `ym_auth_item` VALUES ('/resources/class-scheduling-students/lists', '2', '学员班课课程数据', null, null, '1577090635', '1577090899');
INSERT INTO `ym_auth_item` VALUES ('/resources/resources-course/*', '2', '学生课程', null, null, '1577090642', '1577090718');
INSERT INTO `ym_auth_item` VALUES ('/resources/resources-course/lists', '2', '学员购课数据', null, null, '1577090635', '1577090978');
INSERT INTO `ym_auth_item` VALUES ('/resources/resources/*', '2', '学生资源', null, null, '1577090635', '1577090731');
INSERT INTO `ym_auth_item` VALUES ('/resources/resources/campus-app', '2', '学员应用和校区列表', null, null, '1577090635', '1577090943');
INSERT INTO `ym_auth_item` VALUES ('/resources/resources/resources-info', '2', '学生个人信息', null, null, '1577090635', '1577090961');
INSERT INTO `ym_auth_item` VALUES ('admin', '1', '管理员', null, 0x733A333A2243524D223B, '1576201677', '1576201677');
INSERT INTO `ym_auth_item` VALUES ('campusAdmin', '1', '校区管理员', null, 0x733A31323A22E69599E882B2E7B3BBE7BB9F223B, '1569405466', '1573781909');
INSERT INTO `ym_auth_item` VALUES ('campusCreator', '1', '校区创建者', null, 0x733A31323A22E69599E882B2E7B3BBE7BB9F223B, '1569487791', '1569488656');
INSERT INTO `ym_auth_item` VALUES ('educationalTeacher', '1', '教务老师', null, 0x733A31323A22E69599E882B2E7B3BBE7BB9F223B, '1569487825', '1569488661');
INSERT INTO `ym_auth_item` VALUES ('financial', '1', '财务', null, 0x733A31323A22E69599E882B2E7B3BBE7BB9F223B, '1569487888', '1569488666');
INSERT INTO `ym_auth_item` VALUES ('ordinaryTeacher', '1', '普通老师', null, 0x733A31323A22E69599E882B2E7B3BBE7BB9F223B, '1569487863', '1569488671');
INSERT INTO `ym_auth_item` VALUES ('ordinaryUser', '1', '普通用户', null, null, '1567762437', '1567770563');
INSERT INTO `ym_auth_item` VALUES ('root', '1', '超级管理员', null, 0x733A333A2243524D223B, '1567762455', '1576201639');
INSERT INTO `ym_auth_item` VALUES ('sales', '1', '销售', null, 0x733A31323A22E69599E882B2E7B3BBE7BB9F223B, '1569487908', '1569488676');

-- ----------------------------
-- Table structure for ym_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `ym_auth_item_child`;
CREATE TABLE `ym_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`) USING BTREE,
  KEY `child` (`child`) USING BTREE,
  CONSTRAINT `ym_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ym_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ym_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `ym_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='rbac';

-- ----------------------------
-- Records of ym_auth_item_child
-- ----------------------------
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/app/app-cat-listing');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/app/app-create');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/app/app-listing');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/add-permissions');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/add-role');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/add-role-permissions');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/add-role-role');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/add-user');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/add-user-role');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/all-lists');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/all-lists-with-level');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/all-lists-with-role');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/all-role-with-role');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/all-role-with-user');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/delete-role-permissions');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/delete-role-role');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/delete-user-role');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/index');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/project-directory');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/remove-permissions');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/reset-psw-user');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/update-permissions');
INSERT INTO `ym_auth_item_child` VALUES ('root', '/account/auth-item/user-lists');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/default/all-permissions');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/default/captcha');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/default/forget');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/default/login');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/default/logout');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/default/registered');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/default/sms-code');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/default/tenant-info');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/account/default/update');
INSERT INTO `ym_auth_item_child` VALUES ('admin', '/crm/app/list');
INSERT INTO `ym_auth_item_child` VALUES ('admin', '/crm/campus/list');
INSERT INTO `ym_auth_item_child` VALUES ('admin', '/crm/campus/update');
INSERT INTO `ym_auth_item_child` VALUES ('admin', '/crm/feedback/list');
INSERT INTO `ym_auth_item_child` VALUES ('admin', '/crm/order/list');
INSERT INTO `ym_auth_item_child` VALUES ('admin', '/crm/order/update');
INSERT INTO `ym_auth_item_child` VALUES ('admin', '/crm/package/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/crm/rbac/my-roles');
INSERT INTO `ym_auth_item_child` VALUES ('admin', '/crm/tenant/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/campus/all-permissions');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/campus/campus-renewal');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/campus/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/deduct-course-list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/deduct-course-list');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/deduct-course-list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/deduct-employees-list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/deduct-employees-list');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/deduct-employees-list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/campus/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/campus/myself');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/price-count');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/price-count');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/price-count');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/refund-count');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/refund-count');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/refund-count');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/refund-sum');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/refund-sum');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/refund-sum');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/resources-count');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/resources-count');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/resources-count');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/resources-deduct-count');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/resources-deduct-count');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/resources-deduct-count');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/resources-deduct-list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/resources-deduct-list');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/resources-deduct-list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/resources-sign-count');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/resources-sign-count');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/resources-sign-count');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/campus/total-count');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/campus/total-count');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/campus/total-count');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/campus/update');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling-students/change-classes');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling-students/change-classes');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling-students/class-students');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling-students/class-students');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/class-scheduling-students/class-students');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling-students/class-students');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling-students/create');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling-students/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling-students/delete');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling-students/delete');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling-students/lists');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling-students/lists');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/class-scheduling-students/lists');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling-students/lists');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling-students/sign');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling-students/sign');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling-students/sign');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/all-date-group');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/all-date-group');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/all-time-group');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/all-time-group');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/change-classes');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/change-classes');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/classroom-group');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/classroom-group');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/conclusion');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/conclusion');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling/conclusion');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/count-class-students');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/count-class-students');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/create');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/create');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling/current');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/current-all');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/current-all');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/class-scheduling/current-all');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling/deduct-hour');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/deduct-hour-all');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/deduct-hour-all');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/class-scheduling/deduct-hour-all');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/delete');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/delete');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/employees-group');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/employees-group');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/list-date');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/list-date');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/list-date-employees');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling/list-date-employees');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/list-date-employees-days');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling/list-date-employees-days');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/list-date-employees-time');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling/list-date-employees-time');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/lists');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/lists');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling/lists');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/lists-employees');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling/lists-employees');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/class-scheduling/month-endcount');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/month-endcount-all');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/month-endcount-all');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/class-scheduling/month-endcount-all');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/scheduling-classroom-days');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/scheduling-classroom-days');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/scheduling-employees-days');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/scheduling-employees-days');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-scheduling/scheduling-list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-scheduling/scheduling-list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-students/create');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-students/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-students/delete');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-students/delete');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class-students/lists');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class-students/lists');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class/create');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class/deduct');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class/deduct');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/class/deduct');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class/deduct-students');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class/deduct-students');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/class/deduct-students');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class/delete');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class/delete');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class/end');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class/end');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class/list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class/list');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/class/list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/class/update');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/class/update');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/classroom/create');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/classroom/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/classroom/list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/classroom/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/classroom/list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/classroom/update');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/classroom/update');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/course/create');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/course/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/course/list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/course/list');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/course/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/course/list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/course/update');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/course/update');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/default/all-permissions');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/employees/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/employees/list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/employees/list');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/employees/list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/employees/update');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/feedback/create');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/feedback/delete');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/feedback/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/file/upload');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/order/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/order/update');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/package/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/pay/aop-renewal');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/pay/aop-renewal-notify');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/pay/wxp-renewal');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/edu/pay/wxp-renewal-notify');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-course/count');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-course/count');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/resources-course/count');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/resources-course/count');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-course/create');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-course/create');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/resources-course/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-course/delete');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-course/delete');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/resources-course/delete');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-course/list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-course/list');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/resources-course/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/resources-course/list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-course/refund');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-course/refund');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/resources-course/refund');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-course/update');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-course/update');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/resources-course/update');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-follow/create');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-follow/create');
INSERT INTO `ym_auth_item_child` VALUES ('sales', '/edu/resources-follow/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-follow/delete');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-follow/delete');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-follow/list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-follow/list');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/resources-follow/list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/resources-follow/list');
INSERT INTO `ym_auth_item_child` VALUES ('sales', '/edu/resources-follow/list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources-follow/update');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources-follow/update');
INSERT INTO `ym_auth_item_child` VALUES ('sales', '/edu/resources-follow/update');
INSERT INTO `ym_auth_item_child` VALUES ('sales', '/edu/resources/compute');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources/create');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources/create');
INSERT INTO `ym_auth_item_child` VALUES ('sales', '/edu/resources/create');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources/list');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources/list');
INSERT INTO `ym_auth_item_child` VALUES ('sales', '/edu/resources/list');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources/list-all');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources/list-all');
INSERT INTO `ym_auth_item_child` VALUES ('financial', '/edu/resources/list-all');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', '/edu/resources/list-all');
INSERT INTO `ym_auth_item_child` VALUES ('sales', '/edu/resources/month-count');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources/transfer');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources/transfer');
INSERT INTO `ym_auth_item_child` VALUES ('sales', '/edu/resources/transfer');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', '/edu/resources/update');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', '/edu/resources/update');
INSERT INTO `ym_auth_item_child` VALUES ('sales', '/edu/resources/update');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/resources/class-scheduling-students/class-list');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/resources/class-scheduling-students/list-course');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/resources/class-scheduling-students/lists');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/resources/resources-course/lists');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/resources/resources/campus-app');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryUser', '/resources/resources/resources-info');
INSERT INTO `ym_auth_item_child` VALUES ('root', 'admin');
INSERT INTO `ym_auth_item_child` VALUES ('campusCreator', 'campusAdmin');
INSERT INTO `ym_auth_item_child` VALUES ('admin', 'ordinaryUser');
INSERT INTO `ym_auth_item_child` VALUES ('campusAdmin', 'ordinaryUser');
INSERT INTO `ym_auth_item_child` VALUES ('educationalTeacher', 'ordinaryUser');
INSERT INTO `ym_auth_item_child` VALUES ('financial', 'ordinaryUser');
INSERT INTO `ym_auth_item_child` VALUES ('ordinaryTeacher', 'ordinaryUser');
INSERT INTO `ym_auth_item_child` VALUES ('sales', 'ordinaryUser');

-- ----------------------------
-- Table structure for ym_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `ym_auth_rule`;
CREATE TABLE `ym_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='rbac';

-- ----------------------------
-- Records of ym_auth_rule
-- ----------------------------
INSERT INTO `ym_auth_rule` VALUES ('\\v1\\rules\\AuthorRule', 0x4F3A31393A2276315C72756C65735C417574686F7252756C65223A333A7B733A343A226E616D65223B733A32303A225C76315C72756C65735C417574686F7252756C65223B733A393A22637265617465644174223B693A313532303231373038303B733A393A22757064617465644174223B693A313532303231373038303B7D, '1520217080', '1520217080');
