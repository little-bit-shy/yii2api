<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\models\rbac;

/**
 * Class AuthAssignment
 * @package account\models\rbac
 */
class AuthAssignment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_assignment}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id', 'created_at'], 'safe'],
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
     * @param $user_id
     * @param $item_name
     * @return bool
     */
    public static function exists($user_id, $item_name)
    {
        return self::getExists($user_id, $item_name);
    }

    /**
     * 判断是否已存在该数据
     * @param $user_id
     * @param $item_name
     * @return bool
     */
    private static function getExists($user_id, $item_name)
    {
        return AuthAssignment::find()->where([
            'user_id' => $user_id,
            'item_name' => $item_name,
        ])->exists();
    }
}
