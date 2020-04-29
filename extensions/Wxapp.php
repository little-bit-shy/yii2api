<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2019/12/23
 * Time: 15:28
 */

namespace app\extensions;

use app\components\Helper;
use app\components\StringHelper;
use app\extensions\wxapp\Wxapi;
use yii\helpers\Json;
use yii\web\HttpException;
use Yii;

Class Wxapp extends Wxapi
{
    // 获取用户openid url
    private static $jscode2session = "https://api.weixin.qq.com/sns/jscode2session";

    /**
     * 获取用户openid
     * @param $jsCode
     * @param $source
     * @return mixed
     * @throws HttpException
     */
    public static function getOpenid($jsCode, $source)
    {
        $params = Yii::$app->params;
        $config = $params['wx_app'][$source];

        $appId = $config['appId'];
        $secret = $config['secret'];
        $setData = [
            'appid' => $appId,
            'secret' => $secret,
            'js_code' => $jsCode,
            'grant_type' => 'authorization_code',
        ];
        $result = Json::decode(self::run(self::$jscode2session, $setData, 'GET'), true);
        if (isset($result['errmsg'])) {
            throw new HttpException(500, Yii::t('app/error', 'wechat interface exception'));
        }
        return $result;
    }
}

