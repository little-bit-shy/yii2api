<?php

$authManager = require(__DIR__ . '/authManager.php');
$cacheKeyPrefix = require(__DIR__ . '/cacheKeyPrefix.php');
$wxApp = require(__DIR__ . '/wx_app.php');
$aop = require(__DIR__ . '/aop.php');
$wxp = require(__DIR__ . '/wxp.php');
$cors = require(__DIR__ . '/cors.php');

return [
    'adminEmail' => 'admin@example.com',
    'cacheKeyPrefix' => $cacheKeyPrefix,
    'defaultRoles' => $authManager['defaultRoles'],
    'wx_app' => $wxApp,
    'aop' => $aop,
    'wxp' => $wxp,
    'cors' => $cors,
];

