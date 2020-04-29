<?php

if (YII_ENV_PROD) {
    return [
        'account' => [
            'class' => \yii\db\Connection::className(),
            'dsn' => 'mysql:host=127.0.0.1;dbname=yii2api',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix' => 'y_',
            'queryCache' => 'accountCache',
            'attributes'  => [
                PDO::ATTR_STRINGIFY_FETCHES => false,
            ]
        ],
    ];
} else if (YII_ENV_TEST) {
    return [
        'account' => [
            'class' => \yii\db\Connection::className(),
            'dsn' => 'mysql:host=127.0.0.1;dbname=yii2api',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix' => 'y_',
            'queryCache' => 'accountCache',
            'attributes'  => [
                PDO::ATTR_STRINGIFY_FETCHES => false,
            ]
        ],
    ];
} else if (YII_ENV_DEV) {
    return [
        'account' => [
            'class' => \yii\db\Connection::className(),
            'dsn' => 'mysql:host=127.0.0.1;dbname=yii2api',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix' => 'y_',
            'queryCache' => 'accountCache',
            'attributes'  => [
                PDO::ATTR_STRINGIFY_FETCHES => false,
            ]
        ],
    ];
}
