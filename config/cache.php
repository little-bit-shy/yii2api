<?php

if (YII_ENV_PROD) {
    return [
        'login' => [
            'class' => \yii\redis\Cache::className(),
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 0,
            ],
            'keyPrefix' => 'app_',
        ],
        'account' => [
            'class' => \yii\redis\Cache::className(),
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 1,
            ],
            'keyPrefix' => 'app_',
        ],
        'rbac' => [
            'class' => \yii\redis\Cache::className(),
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 2,
            ],
            'keyPrefix' => 'app_',
        ],
    ];
} else if (YII_ENV_TEST) {
    return [
        'login' => [
            'class' => \yii\redis\Cache::className(),
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 0,
            ],
            'keyPrefix' => 'app_',
        ],
        'account' => [
            'class' => \yii\redis\Cache::className(),
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 1,
            ],
            'keyPrefix' => 'app_',
        ],
        'rbac' => [
            'class' => \yii\redis\Cache::className(),
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 2,
            ],
            'keyPrefix' => 'app_',
        ],
    ];
} else if (YII_ENV_DEV) {
    return [
        'login' => [
            'class' => \yii\redis\Cache::className(),
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 0,
            ],
            'keyPrefix' => 'app_',
        ],
        'account' => [
            'class' => \yii\redis\Cache::className(),
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 1,
            ],
            'keyPrefix' => 'app_',
        ],
        'rbac' => [
            'class' => \yii\redis\Cache::className(),
            'redis' => [
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 2,
            ],
            'keyPrefix' => 'app_',
        ],
    ];
}