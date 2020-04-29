<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\user;

use account\form\Model;
use app\models\User;
use yii\web\HttpException;

/**
 * 表单模型
 * Class TenantInfoForm
 * @package account\form
 */
class TenantInfoForm extends Model
{
    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'tenantInfo' => [
            ]
        ];
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 获取用户信息
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function tenantInfo($param)
    {
        $tenantInfoForm = new TenantInfoForm();
        $tenantInfoForm->setScenario('tenantInfo');
        if ($tenantInfoForm->load([$tenantInfoForm->formName() => $param]) && $tenantInfoForm->validate()) {
            return User::findIdentityByAccessToken(User::getAccessToken());
        } else {
            throw new HttpException(422, $tenantInfoForm->getFirstError());
        }
    }

    /***************************** 获取数据 *********************************/

}