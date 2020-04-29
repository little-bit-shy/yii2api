<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/18
 * Time: 14:57
 * Message: ActiveRecord
 */

namespace app\models\redis;

use Yii;

/**
 * Class ActiveRecord
 * @package app\models\redis
 */
class ActiveRecord extends \yii\redis\ActiveRecord
{
    /**
     * 标识
     * @var
     */
    public static $key;

    /**
     * 获取cache信息
     * @param $key
     * @return array
     */
    public static function getCacheInfo($key)
    {
        $callClass = get_called_class();
        return Yii::$app->params['cacheKeyPrefix'][$callClass::$key][$key];
    }

    /**
     * 获取cache组件
     * @return null|object
     */
    public static function getCache()
    {
        return Yii::$app->get(self::getCacheInfo('cache'));
    }
}