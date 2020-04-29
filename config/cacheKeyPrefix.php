<?php

/**
 * 零散缓存前缀定义
 */

return [
    // 手机验证码
    'smsCode' => [
        'cache' => 'cache',
        'key' => 'smsCode_',
        'duration' => 600,
        // 发送间隔
        'interval' => 60,
    ],
    // 频率限制
    'rateLimit' => [
        'cache' => 'cache',
        'key' => 'rateLimit_',
        // 具体时间业务内定
        'duration' => 0
    ],
    // 用户令牌
    'accessToken' => [
        'cache' => 'cache',
        'key' => 'accessToken_',
        // 7天
        'duration' => 7 * 86400
    ],
];
