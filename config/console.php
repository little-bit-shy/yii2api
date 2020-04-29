<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$modules = require __DIR__ . '/modules.php';
$aliases = require __DIR__ . '/aliases.php';
$cache = require __DIR__ . '/cache.php';
$request = require(__DIR__ . '/request.php');
$log = require __DIR__ . '/log.php';
$i18n = require(__DIR__ . '/i18n.php');


$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    // 设置目标语言为中文
    'language' => 'zh-CN',
    // 设置源语言为英语
    'sourceLanguage' => 'en-US',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        // 令牌、频率缓存配置
        'cache' => $cache['login'],
        // 个人中心缓存配置
        'accountCache' => $cache['account'],
        // 教育系统缓存配置
        'eduCache' => $cache['edu'],
        // 日志配置
        'log' => $log,
        // 个人中心数据库配置
        'accountDb' => $db['account'],
        // 教育系统数据库配置
        'eduDb' => $db['edu'],
        //国际化处理
        'i18n' => $i18n,
    ],
    //模块相关配置
    'modules' => $modules,
    // 别名定义
    'aliases' => $aliases,
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
