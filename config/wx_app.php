<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2019/12/2
 * Time: 9:42
 */
if (YII_ENV_PROD) {
    return [
        //小程序
        'resources' => [
            'appId' => '*************',
            'secret' => '*************',
            'merchantId' => '*************',            //商户号（必须配置，开户邮件中可查看）
            'signType' => 'MD5',            //支持md5和sha256方式
            'key' => '*************',   //商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）, 请妥善保管， 避免密钥泄露
            'sslCertPath' => "-----BEGIN CERTIFICATE-----
*************
-----END CERTIFICATE-----",
            'sslKeyPath' => "-----BEGIN PRIVATE KEY-----
*************
-----END PRIVATE KEY-----",
        ],
    ];
} else if (YII_ENV_TEST) {
    return [
        //小程序
        'resources' => [
            'appId' => '*************',
            'secret' => '*************',
            'merchantId' => '*************',            //商户号（必须配置，开户邮件中可查看）
            'signType' => 'MD5',            //支持md5和sha256方式
            'key' => '*************',   //商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）, 请妥善保管， 避免密钥泄露
            'sslCertPath' => "-----BEGIN CERTIFICATE-----
*************
-----END CERTIFICATE-----",
            'sslKeyPath' => "-----BEGIN PRIVATE KEY-----
*************
-----END PRIVATE KEY-----",
        ],
    ];
} else if (YII_ENV_DEV) {
    return [
        //小程序
        'resources' => [
            'appId' => '*************',
            'secret' => '*************',
            'merchantId' => '*************',            //商户号（必须配置，开户邮件中可查看）
            'signType' => 'MD5',            //支持md5和sha256方式
            'key' => '*************',   //商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）, 请妥善保管， 避免密钥泄露
            'sslCertPath' => "-----BEGIN CERTIFICATE-----
*************
-----END CERTIFICATE-----",
            'sslKeyPath' => "-----BEGIN PRIVATE KEY-----
*************
-----END PRIVATE KEY-----",
        ],
    ];
}