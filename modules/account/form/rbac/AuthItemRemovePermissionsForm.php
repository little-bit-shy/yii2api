<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\rbac;

use account\form\Model;
use app\components\AppRoutes;
use app\components\ArrayHelper;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemRemovePermissionsForm
 * @package account\form\rbac
 */
class AuthItemRemovePermissionsForm extends Model
{
    public $name;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe', 'on' => 'remove-permissions'],
            [['name'], 'required', 'on' => 'remove-permissions'],
            [['name'], 'trim', 'on' => 'remove-permissions'],
            [['name'], 'string', 'on' => 'remove-permissions'],
            [['name'], 'validateName', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'remove-permissions'],
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
        // 权限是否存在
        $permission = $auth->getPermission($this->name);
        if(empty($permission)){
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
            'remove-permissions' => [
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
     * 删除权限
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function removePermissions($param)
    {
        // 表单模型实例化
        $authItemRemovePermissionsForm = new AuthItemRemovePermissionsForm();
        // 场景定义
        $authItemRemovePermissionsForm->setScenario('remove-permissions');
        // 验证数据是否合法
        if ($authItemRemovePermissionsForm->load([$authItemRemovePermissionsForm->formName() => $param]) && $authItemRemovePermissionsForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemRemovePermissionsForm->getAttributes();

            $auth = Yii::$app->getAuthManager();
            $permission = $auth->createPermission($attributes['name']);
            if ($auth->remove($permission)) {
                throw new HttpException(200, Yii::t('app/success', 'data delete successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemRemovePermissionsForm->getFirstError());
        }
    }

}