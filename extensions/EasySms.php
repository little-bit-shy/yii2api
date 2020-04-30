<?php

namespace app\extensions;

use Yii;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use yii\base\BaseObject;
use yii\web\HttpException;

/**
 * 手机短信
 * Class Sms
 * @package app\components
 */
class EasySms extends BaseObject
{
    /** @var $config array 配置 */
    public $config;
    /** @var $template string 短信模板 */
    public $template;

    /**
     * 发送验证码短信
     * @param $mobile
     * @param $code
     * @return array
     * @throws HttpException
     */
    public function sendSmsCode($mobile, $code)
    {
        $template = $this->template;
        try {
            return (new \Overtrue\EasySms\EasySms($this->config))->send($mobile, [
                'template' => $template['smsCode'],
                'data' => [
                    $code
                ],
            ]);
        } catch (NoGatewayAvailableException $e) {
            throw new HttpException(500, Yii::t('app/error', 'sms gateway exception'));
        }
    }
}