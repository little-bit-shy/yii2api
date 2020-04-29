<?php

/**
 * 支付宝相关配置
 *
 * 买家账号yjfbfs0198@sandbox.com
 * 登录密码111111
 * 支付密码111111
 * 用户名称沙箱环境
 * 证件类型身份证(IDENTITY_CARD)
 * 证件号码306003199609120405
 */

if (YII_ENV_PROD) {
    return [
        'gatewayUrl' => 'https://openapi.alipay.com/gateway.do',
        'appId' => '**********',
        'rsaPrivateKey' => "**********",
        'alipayrsaPublicKey' => "**********",
        'apiVersion' => '1.0',
        'signType' => 'RSA2',
        'postCharset' => 'utf-8',
        'format' => 'json',
    ];
} else if (YII_ENV_TEST) {
    return [
        'gatewayUrl' => 'https://openapi.alipaydev.com/gateway.do',
        'appId' => '**********',
        'rsaPrivateKey' => "**********",
        'alipayrsaPublicKey' => "**********",
        'apiVersion' => '1.0',
        'signType' => 'RSA2',
        'postCharset' => 'utf-8',
        'format' => 'json',
    ];
} else if (YII_ENV_DEV) {
    return [
        'gatewayUrl' => 'https://openapi.alipaydev.com/gateway.do',
        'appId' => '**********',
        'rsaPrivateKey' => "**********",
        'alipayrsaPublicKey' => "**********",
        'apiVersion' => '1.0',
        'signType' => 'RSA2',
        'postCharset' => 'utf-8',
        'format' => 'json',
    ];
}