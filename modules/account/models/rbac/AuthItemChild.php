<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\models\rbac;

use yii\caching\TagDependency;
use Yii;

/**
 * Class AuthItemChild
 * @package account\models\rbac
 */
class AuthItemChild extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_item_child}}';
    }

    /**
     * 验证器
     * @return array
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'safe'],
        ];
    }

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * url上加fields参数获取
     * @return array
     */
    public function fields()
    {
        return parent::fields();
    }

    /**
     * 一般extraFields() 主要用于指定哪些值为对象的字段
     * url上加expand参数获取
     * @return array
     */
    public function extraFields()
    {
        return parent::extraFields();
    }

    /***************************** 触发事件 *********************************/

    /***************************** 关联数据 *********************************/

    /***************************** 增删改查 *********************************/

    /**
     * 判断是否已存在该数据
     * @param $parent
     * @param $child
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function exists($parent, $child)
    {
        return ActiveRecord::getDb()->cache(function ($db) use ($parent, $child) {
            return self::getExists($parent, $child);
        }, AuthAssignment::$dataTimeOut, new TagDependency(['tags' => [AuthAssignment::getAllDataTag()]]));
    }

    /**
     * 判断是否已存在该数据
     * @param $parent
     * @param $child
     * @return bool
     */
    private static function getExists($parent, $child)
    {
        return AuthItemChild::find()->where([
            'parent' => $parent,
            'child' => $child,
        ])->exists();
    }
}
