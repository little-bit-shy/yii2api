<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\rbac;

use account\form\Model;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemRemoveRoleForm
 * @package account\form\rbac
 */
class AuthItemRemoveRoleForm extends Model
{
    public $name;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe', 'on' => 'remove-role'],
            [['name'], 'required', 'on' => 'remove-role'],
            [['name'], 'trim', 'on' => 'remove-role'],
            [['name'], 'string', 'on' => 'remove-role'],
            [['name'], 'validateName', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'remove-role'],
        ];
    }

    /**
     * 验证name参数是否合法
     * @param $attribute
     * @param $params
     */
    public function validateName($attribute, $params)
    {
        $auth = Yii::$app->getAuthManager();
        // 角色是否存在
        $role = $auth->getRole($this->name);
        if(empty($role)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'remove-role' => [
                'name',
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
            'name' => Yii::t('app\attribute', 'name'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 删除角色
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function removeRole($param)
    {
        // 表单模型实例化
        $authItemRemoveRoleForm = new AuthItemRemoveRoleForm();
        // 场景定义
        $authItemRemoveRoleForm->setScenario('remove-role');
        // 验证数据是否合法
        if ($authItemRemoveRoleForm->load([$authItemRemoveRoleForm->formName() => $param]) && $authItemRemoveRoleForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemRemoveRoleForm->getAttributes();

            $auth = Yii::$app->getAuthManager();
            $role = $auth->createRole($attributes['name']);
            if ($auth->remove($role)) {
                throw new HttpException(200, Yii::t('app/success', 'data delete successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemRemoveRoleForm->getFirstError());
        }
    }

}