<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\models\rbac;

use account\models\ActiveRecord;

/**
 * Class AuthRule
 * @package account\models\rbac
 */
class AuthRule extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_rule}}';
    }

    /**
     * 验证器
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'data', 'created_at', 'updated_at'], 'safe'],
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
}
