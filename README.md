# yii2api


对yii2框架底层做了一些相关优化

开发者可以更快捷方便的使用框架

而不必过多的关注底层业务逻辑

```bash
# 项目目录
yii2-rest
├─# Cli脚本目录
├─commands
├─# 扩展组件目录
├─components
│  ├─# 获取当前项目所有路由
│  ├─AppRoutes.php
│  ├─# 省市区数据验证器
│  ├─AreaValidator.php
│  ├─# 数组辅助函数扩展
│  ├─ArrayHelper.php
│  ├─# 辅助函数
│  ├─Helper.php
│  ├─# 模糊查询数验证器
│  ├─LikeValidator.php
│  ├─# 多值数据验证器，类似in但支持多个值
│  ├─SetValidator.php
│  ├─# 字符串辅助函数扩展
│  ├─StringHelper.php
│  └─
├─# 公共配置目录
├─config
│  ├─# 国际化语言包
│  ├─messages
│  ├─# 项目别名，用于类自动加载（yii机制实现）
│  ├─aliases.php
│  ├─# 权限控制配置
│  ├─authManager.php
│  ├─# 缓存配置
│  ├─cache.php
│  ├─# 零散缓存Key配置
│  ├─cacheKeyPrefix.php
│  ├─# 数据库配置
│  ├─db.php
│  ├─# 国际化配置（这里对国际化做了二次处理，包含异常状态码）
│  ├─i18n.php
│  ├─# 日志配置（这里对记录数据做了格式化处理）
│  ├─log.php
│  ├─# 跨域Cors配置
│  ├─cors.php
│  ├─# 模块配置
│  ├─modules.php
│  ├─# 扩展配置
│  ├─params.php
│  ├─# 请求配置
│  ├─request.php
│  ├─# 响应配置（这里做了数据格式化输出处理）
│  ├─response.php
│  ├─# 短信配置
│  ├─sms.php
│  ├─# url美化
│  ├─urlManager.php
│  ├─# 用户登陆相关配置
│  ├─user.php
│  ├─# 微信小程序相关配置
│  ├─wx_app.php
│  ├─# 微信支付相关配置
│  ├─wxp.php
│  ├─# 支付宝支付相关配置
│  ├─apo.php
│  └─
├─# 控制器目录
├─controllers
|  ├─# controller基类实现
|  ├─# 实现了Cors、QueryParamAuth、RateLimiter、AccessControl中间件
|  ├─Controller.php
|  ├─# 扩展中间件
|  ├─behaviors
│  │  ├─# 登陆令牌验证中间件继承实现
│  │  ├─QueryParamAuth.php
│  │  ├─# Action返回数据二次处理中间件继承实现
│  │  ├─Serializer.php
│  │  └─
│  └─
├─# 扩展目录
├─extensions
|  ├─# 支付宝支付工具类
|  ├─Apo.php
|  ├─# 微信小程序工具类
|  ├─Wxapp.php
|  ├─# 微信支付工具类
|  ├─Wxp.php
│  ├─# 短信发送（知名平台都支持）
│  ├─EasySms.php
│  └─
├─# 模型目录
├─models
|  ├─# 表单模型目录
|  ├─form
│  │  ├─# Model基类实现
│  │  ├─# 添加getFirstError获取单条报错信息
│  │  ├─Model.php
│  │  └─
|  ├─# redis数据模型目录
|  ├─redis
│  │  ├─# ActiveRecord基类实现
│  │  ├─# 依赖cacheKeyPrefix配置文件实现
│  │  ├─ActiveRecord.php
│  │  ├─# 基于ActiveRecord实现用户令牌（增删改查）
│  │  ├─AccessToken.php
│  │  ├─# 基于ActiveRecord实现用户接口请求频率限制源数据（增删改查）
│  │  ├─RateLimit.php
│  │  └─
|  ├─# ActiveQuery基类实现
|  ├─# 添加依据expand确认是否调用实际with操作（减少数据库操作）
|  ├─# 添加some方法类似with
|  ├─# with不支持一个字段存多个值（示例：1,2,3）的时候执行关联数据
|  ├─# some对这块做了支持操作,多值字段分隔符支持自定义
|  ├─# 添加了forUpdate
|  ├─ActiveQuery.php
|  ├─# ActiveRecord基类实现
|  ├─# 通过extraFields解决Action返回ActiveRecord时无法返回with >= 2级嵌套关联数据Bug
|  ├─# 缓存依赖封装处理使用只需在查询数据时指定对应缓存依赖即可
|  ├─# 底层自动回收过期缓存
|  ├─ActiveRecord.php
|  ├─# DynamicModel基类实现
|  ├─# 添加getFirstError获取单条报错信息
|  ├─DynamicModel.php
|  ├─# User基类实现，包括频率限制
|  ├─User.php
│  └─
├─# 模块目录
├─modules
│  ├─# account模块目录
│  ├─account
│  │  ├─# 配置目录
│  │  ├─config
│  │  ├─# 控制器目录
│  │  ├─controllers
│  │  ├─# 模型目录
│  │  ├─models
│  │  │  ├─# 表单模型目录
│  │  │  ├─form
│  │  │  ├─# Redis模型目录
│  │  │  ├─redis
│  │  │  └─
│  │  ├─# 初始化模块脚本
│  │  ├─Module.php
│  │  └─
│  └─
├─# 权限web管理系统，使用前记得cnpm install
├─rbac
│ ├─# 记得修改配置文件
│ ├─build
│ └─
├─# 数据库版本控制目录
├─database
│ ├─# 常规初始化数据
│ ├─yii2api.sql
│ ├─# 权限初始化数据
│ ├─yii2api_rbac.php
│ └─
├─# 项目入口目录
├─web
│ ├─# 开发入口脚本
│ ├─dev.php
│ ├─# 生产入口脚本
│ ├─prod.php
│ ├─# 测试入口脚本
│ ├─test.php
│ └─
│
├─# composer工具
├─composer.phar
├─# 开发入口脚本
├─yii_dev
├─# 生产入口脚本
├─yii_prod
├─# 测试入口脚本
├─yii_test
└─
```

#### Nginx路由优化配置
```bash
server {
    listen 80;
    server_name localhost;
    autoindex off;

    #直接输入域名进入的目录和默认解析的文件
    location / {
        try_files $uri $uri/ /prod.php?s=$uri&$args;
    }

    #解析.php的文件
    location ~ \.php$ {
        root /www/yii2-rest/web/;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### 权限web管理系统效果展示
初始化账号密码 15918793994/123456

![img](/help/1.jpg)

![img](/help/2.jpg)

![img](/help/3.jpg)

![img](/help/4.jpg)