<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/18
 * Time: 14:57
 * Message: 手机验证码相关数据模型（居于Redis实现）
 */

namespace account\redis;

use app\components\StringHelper;
use app\extensions\EasySms;
use Yii;
use yii\web\HttpException;

/**
 * Class SmsCode
 * @package app\models\redis
 */
class SmsCode extends ActiveRecord
{

    public static $key = 'smsCode';

    /***************************** 增删改查 *********************************/

    /**
     * 获取当前手机验证码
     * @param $mobile
     * @return mixed
     */
    public static function findMobile($mobile, $smsCode = null)
    {
        $cache = self::getCache();
        // 获取手机验证码缓存key前缀
        $key = self::getCacheInfo('key');
        $key .= $mobile;
        $captcha = $cache->get($key);
        if ($smsCode == $captcha['sms_code']) {
            $cache->delete($key);
        }
        return $captcha;
    }

    /**
     * 创建验证码
     * @param $mobile
     * @return array
     * @throws HttpException
     */
    public static function createSmsCode($mobile)
    {
        $smsCode = StringHelper::rand(1000, 9999);
        $time = time();
        $cache = self::getCache();
        // 获取手机验证码缓存key前缀
        $key = self::getCacheInfo('key');
        $key .= $mobile;
        // 获取手机验证码缓存key持续时间
        $duration = self::getCacheInfo('duration');

        /** @var EasySms $sms */
        $sms = Yii::$app->sms;
        // 发送验证码
        $sms->sendSmsCode($mobile, $smsCode);

        $data = [
            'mobile' => $mobile,
            'sms_code' => $smsCode,
            'send_at' => $time,
        ];
        $cache->set($key, $data, $duration);
        return $data;
    }
}