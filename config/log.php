<?php

/**
 * 选用数据库为日志载体，记得先创建日志表
 * CREATE TABLE `ym_log` (
 * `id` bigint(20) NOT NULL AUTO_INCREMENT,
 * `level` int(11) DEFAULT NULL,
 * `category` varchar(255) DEFAULT NULL,
 * `log_time` double DEFAULT NULL,
 * `prefix` mediumtext,
 * `message` mediumtext,
 * PRIMARY KEY (`id`),
 * KEY `idx_log_level` (`level`),
 * KEY `idx_log_category` (`category`)
 * ) ENGINE=InnoDB AUTO_INCREMENT=5679 DEFAULT CHARSET=utf8mb4;
 */

$db = require __DIR__ . '/db.php';

/**
 * @param $message
 * @return mixed
 */
$prefix = function ($message) {
    // 获取userid
    $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
    $userId = $user ? empty($user->getId(false)) ? 0 : $user->getId(false) : 0;
    // 获取客户端ip
    $serverIp = Yii::$app->getRequest()->getUserIP();
    $serverIp = $serverIp ? $serverIp : '';
    // 获取会话信息
    $sessionId = (new \yii\web\Session())->getId();
    $sessionId = $sessionId ? $sessionId : '';
    // 获取路由
    $pathInfo = Yii::$app->getRequest()->getPathInfo();
    $pathInfo = $pathInfo ? $pathInfo : '';
    // 获取请求头参数
    $queryParams = Yii::$app->getRequest()->getQueryString();
    $queryParams = $queryParams ? $queryParams : '';
    // 获取请求体参数
    $bodyParams = Yii::$app->getRequest()->getBodyParams();
    $bodyParams = $bodyParams ? \yii\helpers\Json::encode($bodyParams) : '';
    $prefix = \yii\helpers\Json::encode([
        "userId" => $userId,
        "serverIp" => $serverIp,
        "sessionId" => $sessionId,
        "pathInfo" => $pathInfo,
        "queryParams" => $queryParams,
        "bodyParams" => $bodyParams,
    ]);
    return $prefix;
};

if (YII_ENV_PROD) {
    return [
        'traceLevel' => 0,
        'targets' => [
            [
                // 用户自定义日志
                'class' => yii\log\DbTarget::className(),
                'db' => 'accountDb',
                'exportInterval' => 0,
                'logVars' => [],
                'levels' => ['info', 'warning'],
                'categories' => [
                    'application',
                ],
                'prefix' => $prefix
            ],
        ]
    ];
} else if (YII_ENV_TEST) {
    return [
        'traceLevel' => 0,
        'targets' => [
            [
                // 用户自定义日志
                'class' => yii\log\DbTarget::className(),
                'db' => 'accountDb',
                'exportInterval' => 0,
                'logVars' => [],
                'levels' => ['info', 'warning'],
                'categories' => [
                    'application',
                ],
                'prefix' => $prefix
            ],
        ]
    ];
} else if (YII_ENV_DEV) {
    return [
        'traceLevel' => 0,
        'targets' => [
            [
                // 用户自定义日志
                'class' => yii\log\DbTarget::className(),
                'db' => 'accountDb',
                'exportInterval' => 0,
                'logVars' => [],
                'levels' => ['info', 'warning'],
                'categories' => [
                    'application',
                ],
                'prefix' => $prefix
            ],
            [
                // sql语句日志
                'class' => yii\log\FileTarget::className(),
                'maxFileSize' => 102400,
                'maxLogFiles' => 20,
                'logVars' => [],
                'levels' => ['info', 'error', 'warning'],
                'categories' => [
                    'yii\db\*',
                ],
                'logFile' => '@runtime/logs/sql.log',
            ],
        ]
    ];
}
