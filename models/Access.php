<?php

namespace app\models;

use Yii;

/**
 * Class Access
 * @package account\models
 */
class Access extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%access_token}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'access_token', 'tenant_id', 'create_at', 'update_at', 'remove_at'], 'safe'],
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
