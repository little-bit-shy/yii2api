<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2019/12/19
 * Time: 15:53
 */

namespace account\models;

Class TenantWx extends ActiveRecord
{
    /** 来源 1/校区端  **/
    const WX_SOURCE_ONE = 1;
    /** 来源 2/学生端  **/
    const WX_SOURCE_TWO = 2;

    public static function tableName()
    {
        return '{{%tenant_wx}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['tenant_wx_id', 'tenant_id', 'openid', 'source', 'create_at', 'update_at'], 'safe'],
        ];
    }

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * url上加fields参数获取
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function fields()
    {
        return parent::fields();
    }

    /***************************** 关联数据 *********************************/

    /***************************** 增删改查 *********************************/
}