<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/18
 * Time: 14:57
 * Message: Api调用频率相关数据模型（居于Redis实现）
 */

namespace app\models\redis;

use Yii;

/**
 * Class RateLimit
 * @package app\models\redis
 */
class RateLimit extends ActiveRecord
{
    public static $key = 'rateLimit';

    //Api在 $second 秒内能请求 $rateLimit 次
    public static $rateLimit = 100;
    public static $second = 1;

    /***************************** 增删改查 *********************************/

    /**
     * 获取当前登录用户Api请求频率相关数据
     * @param $id
     * @param $uniqueId
     * @return array|null|\yii\redis\ActiveRecord
     */
    public static function one($id, $uniqueId)
    {
        $cache = self::getCache();
        $key = self::getCacheInfo('key') . $id . $uniqueId;
        $data = $cache->get($key);
        return $data;
    }

    /**
     * 更新当前登录用户Api请求频率相关数据
     * @param $id
     * @param $uniqueId
     * @param $allowance
     * @param $timestamp
     * @throws \yii\base\InvalidConfigException
     */
    public static function saveAllowance($id, $uniqueId, $allowance, $timestamp)
    {
        $cache = self::getCache();
        $key = self::getCacheInfo('key') . $id . $uniqueId;
        $cache->set($key, [
            'id' => $id,
            'unique_id' => $uniqueId,
            'allowance' => $allowance,
            'allowance_updated_at' => $timestamp,
        ], self::$second);
    }
}