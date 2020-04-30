<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$urlManager = require __DIR__ . '/urlManager.php';
$modules = require __DIR__ . '/modules.php';
$aliases = require __DIR__ . '/aliases.php';
$log = require __DIR__ . '/log.php';
$user = require __DIR__ . '/user.php';
$cache = require __DIR__ . '/cache.php';
$authManager = require(__DIR__ . '/authManager.php');
$request = require(__DIR__ . '/request.php');
$response = require(__DIR__ . '/response.php');
$i18n = require(__DIR__ . '/i18n.php');
$sms = require(__DIR__ . '/sms.php');


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    // 设置目标语言为中文
    'language' => 'zh-CN',
    // 设置源语言为英语
    'sourceLanguage' => 'en-US',
    'timeZone' => 'Asia/Shanghai',
    'bootstrap' => ['log'],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        // 用户验证配置
        'user' => $user,
        // 日志配置
        'log' => $log,
        // 个人中心数据库配置
        'accountDb' => $db['account'],
        // 权限控制数据库配置
        'rbacDb' => $db['rbac'],
        //路由配置
        'urlManager' => $urlManager,
        // 令牌、频率缓存配置
        'cache' => $cache['login'],
        // 个人中心缓存配置
        'accountCache' => $cache['account'],
        // 权限控制缓存配置
        'rbacCache' => $cache['rbac'],
        //rbac权限管理
        'authManager' => $authManager,
        //请求相关配置
        'request' => $request,
        //响应相关配置
        'response' => $response,
        //国际化处理
        'i18n' => $i18n,
        //手机短信
        'sms' => $sms
    ],
    //模块相关配置
    'modules' => $modules,
    //别名定义
    'aliases' => $aliases,
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        'allowedIPs' => ['*'],
//    ];
}

return $config;
