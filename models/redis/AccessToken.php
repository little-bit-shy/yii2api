<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/18
 * Time: 14:57
 * Message: 用户令牌相关数据模型（居于Redis实现）
 */

namespace app\models\redis;

use Yii;

/**
 * Class AccessToken
 * @package app\models\redis
 */
class AccessToken extends ActiveRecord
{
    public static $key = 'accessToken';

    /***************************** 增删改查 *********************************/

    /**
     * 获取当前登录用户AccessToken相关信息
     * @param $accessToken
     * @return array|null|\yii\redis\ActiveRecord
     */
    public static function findAccessToken($accessToken)
    {
        $cache = self::getCache();
        $key = self::getCacheInfo('key') . $accessToken;
        return $cache->get($key);
    }

    /**
     * 为登录用户创建AccessToken相关数据
     * @param $tenantId
     * @return array
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function createAccessToken($tenantId)
    {
        $cache = self::getCache();
        $removeAt = time() + self::getCacheInfo('duration');
        $accessToken = md5(Yii::$app->getSecurity()->generateRandomString() . '_' . $tenantId);
        $key = self::getCacheInfo('key') . $accessToken;
        $data = [
            'access_token' => $accessToken,
            'tenant_id' => $tenantId,
            'remove_at' => $removeAt,
        ];
        $cache->set($key, $data, self::getCacheInfo('duration'));
        return $data;
    }

    /**
     * 删除token
     * @param $accessToken
     * @return false|int
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public static function removeAccessToken($accessToken)
    {
        $cache = self::getCache();
        $key = self::getCacheInfo('key') . $accessToken;
        return $cache->delete($key);
    }
}