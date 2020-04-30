<?php

if (YII_ENV_PROD) {
    return [
        'class' => '\app\extensions\EasySms',
        'config' => [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => '\Overtrue\EasySms\Strategies\OrderStrategy',

                // 默认可用的发送网关
                'gateways' => [
                    'huawei',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'huawei' => [
                    'endpoint' => 'https://rtcsms.cn-north-1.myhuaweicloud.com:10743', // APP接入地址
                    'app_key' => '******************', // APP KEY
                    'app_secret' => '******************', // APP SECRET
                    'from' => [
                        'default' => '******************', // 默认使用签名通道号
                    ],
                    'callback' => '' // 短信状态回调地址
                ],
            ],
        ],
        'template' => [
            'smsCode' => '******************'
        ]
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => '\app\extensions\EasySms',
        'config' => [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => '\Overtrue\EasySms\Strategies\OrderStrategy',

                // 默认可用的发送网关
                'gateways' => [
                    'huawei',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'huawei' => [
                    'endpoint' => 'https://rtcsms.cn-north-1.myhuaweicloud.com:10743', // APP接入地址
                    'app_key' => '******************', // APP KEY
                    'app_secret' => '******************', // APP SECRET
                    'from' => [
                        'default' => '******************', // 默认使用签名通道号
                    ],
                    'callback' => '' // 短信状态回调地址
                ],
            ],
        ],
        'template' => [
            'smsCode' => '******************'
        ]
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => '\app\extensions\EasySms',
        'config' => [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => '\Overtrue\EasySms\Strategies\OrderStrategy',

                // 默认可用的发送网关
                'gateways' => [
                    'huawei',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'huawei' => [
                    'endpoint' => 'https://rtcsms.cn-north-1.myhuaweicloud.com:10743', // APP接入地址
                    'app_key' => '******************', // APP KEY
                    'app_secret' => '******************', // APP SECRET
                    'from' => [
                        'default' => '******************', // 默认使用签名通道号
                    ],
                    'callback' => '' // 短信状态回调地址
                ],
            ],
        ],
        'template' => [
            'smsCode' => '******************'
        ]
    ];
}