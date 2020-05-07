<?php

namespace app\models;


use app\components\ArrayHelper;
use Yii;
use yii\caching\TagDependency;
use yii\db\Exception;
use yii\db\Query;
use yii\helpers\StringHelper;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /** 数据未冻结 */
    const IS_ABLE = 1;
    /** 数据已冻结 */
    const IS_NOT_ABLE = 2;

    /** 数据未删除 */
    const IS_NOT_DELETE = 1;
    /** 数据已删除 */
    const IS_DELETE = 2;

    public static function getDb()
    {
        return Yii::$app->get('accountDb');
    }

    /**
     * 替换 ActiveQuery
     * @return Query
     * @throws \yii\base\InvalidConfigException
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * 数据缓存过期时间
     * @var int
     */
    public static $dataTimeOut = 600;

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * url上加fields参数获取
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();
        foreach ($fields as $key => &$value) {
            if (StringHelper::endsWith($key, '_at') && !empty($this->$key)) {
                $value = function () use ($key) {
                    return date('Y-m-d H:i:s', $this->$key);
                };
            }
        }
        return $fields;
    }

    /**
     * 一般extraFields() 主要用于指定哪些值为对象的字段
     * url上加expand参数获取
     * @return array
     */
    public function extraFields()
    {
        $relatedRecords = $this->getRelatedRecords();
        $fields = array_keys($relatedRecords);
        foreach ($fields as $value) {
            // 获取所有子关联级相关数据
            $fields[$value] = function (self $model) use ($value) {
                /** @var ActiveRecord $activeRecord */
                $activeRecord = $model->$value;
                if (empty($activeRecord)) {
                    return null;
                } else {
                    if (is_array($activeRecord)) { // 一对多
                        $activeRecords = $activeRecord;
                        $result = [];
                        foreach ($activeRecords as $activeRecord) {
                            $field = array_keys($activeRecord->getRelatedRecords());
                            $result[] = $activeRecord->toArray([], $field, true);
                        }
                        return $result;
                    } else { // 一对一
                        $field = array_keys($activeRecord->getRelatedRecords());
                        return $activeRecord->toArray([], $field, true);
                    }
                }
            };
        }
        return $fields;
    }

    /***************************** 缓存依赖 *********************************/

    /**
     * 缓存依赖缓存驱动
     * @return \yii\caching\CacheInterface
     */
    public static function getTagCache()
    {
        $callClass = get_called_class();
        $callClass = new $callClass();
        return Yii::$app->get($callClass->getDb()->queryCache);
    }

    /**
     * 记录数据表中对应的用户id列
     * 使用该依赖时，写对应表数据时，对应的字段的值所属的缓存依赖自动回收
     * 无须手动操作
     * @return array
     */
    private static function userColumn()
    {
        return [
            'own_tenant_id',
            'from_tenant_id',
            'to_tenant_id',
            'tenant_id',
            'user_id',
            'mobile'
        ];
    }

    /**
     * 获取数据缓存依赖key前缀
     * @return string
     */
    public static function getTagKeyPrefix()
    {
        $callClass = get_called_class();
        $callClass = new $callClass();
        $db = $callClass->getDb();
        return $db->dsn . ';tablename=' . $db->quoteSql(self::tableName()) . ';';
    }

    /**
     * 公共数据的依赖
     * 使用该依赖时，写对应表数据时，对应整个表的缓存依赖自动回收
     * @return string
     */
    public static function getAllDataTag()
    {
        return self::getTagKeyPrefix() . 'all';
    }

    /**
     * 个人数据的依赖
     * @param array|string  $userId 支持传数组
     * @param bool $forOneReturnArray 返回数据是否强制为数组
     * @return array|string
     */
    public static function getUserDataTag($userId, $forOneReturnArray = false)
    {

        if (!ArrayHelper::isArray($userId)) {
            if ($forOneReturnArray) {
                $userData = [self::getTagKeyPrefix() . 'user_' . $userId];
            } else {
                $userData = self::getTagKeyPrefix() . 'user_' . $userId;
            }
        } else {
            $userData = [];
            foreach ($userId as $value) {
                $userData[] = self::getTagKeyPrefix() . 'user_' . $value;
            }
        }
        return $userData;
    }

    /***************************** 触发事件 *********************************/

    /**
     * 数据写操作前触发的事件
     * 缓存依赖清除
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->tagDependencyInvalidate();
        return parent::beforeSave($insert);
    }

    /**
     * 数据写操作后触发的事件
     * 缓存依赖清除
     * @param bool $insert
     * @param array $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->tagDependencyInvalidate();
        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * 数据删除操作前触发的事件
     * 缓存依赖清除
     */
    public function beforeDelete()
    {
        $this->tagDependencyInvalidate();
        return parent::beforeDelete();
    }

    /**
     * 使缓存依赖标签对应的子数据清空
     * @return bool
     */
    public function tagDependencyInvalidate()
    {
        try {
            // 全量数据缓存依赖清除
            $tags = [self::getAllDataTag()];
            // 用户数据缓存依赖清除
            $cols = $this->userColumn();
            foreach ($cols as $col) {
                $colData = $this->getAttribute($col);
                if (!empty($colData)) {
                    $userDataTag = self::getUserDataTag($colData, true);
                    $tags = ArrayHelper::merge($tags, $userDataTag);
                }
            }

            // 数据缓存清除
            TagDependency::invalidate(self::getTagCache(), $tags);
        } catch (Exception $e) {
            return false;
        }
    }
}
