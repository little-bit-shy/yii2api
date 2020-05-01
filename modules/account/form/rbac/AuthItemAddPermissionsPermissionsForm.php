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
 * Class AuthItemAddPermissionsPermissionsForm
 * @package account\form\rbac
 */
class AuthItemAddPermissionsPermissionsForm extends Model
{
    public $permissions;
    public $child_permissions;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['permissions', 'child_permissions'], 'safe', 'on' => 'add-permissions-permissions'],
            [['permissions', 'child_permissions'], 'required', 'on' => 'add-permissions-permissions'],
            [['permissions', 'child_permissions'], 'trim', 'on' => 'add-permissions-permissions'],
            [['permissions', 'child_permissions'], 'string', 'on' => 'add-permissions-permissions'],
            [['permissions'], 'validatePermissionsAndChildPermissions', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'add-permissions-permissions']
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'add-permissions-permissions' => [
                'permissions',
                'child_permissions'
            ]
        ];
    }

    /**
     * 验证权限、权限关系是否合法
     * @param $attribute
     * @param $params
     */
    public function validatePermissionsAndChildPermissions($attribute, $params)
    {
        $auth = Yii::$app->getAuthManager();
        // 权限是否存在
        $permission = $auth->getPermission($this->permissions);
        if(empty($permission)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }

        // 权限是否存在
        $child_permission = $auth->getPermission($this->child_permissions);
        if(empty($child_permission)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }

        // 确认关系是否存在
        if($auth->hasChild($permission, $child_permission) == true){
            $this->addError($attribute, Yii::t('app/error', 'the data exist'));
            return;
        }

        // 验证权限、角色关系是否合法
        if (!$auth->canAddChild($permission, $child_permission)) {
            $this->addError($attribute, Yii::t('app/error', 'the current data cannot be add'));
            return;
        }
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app\attribute', 'name'),
            'role' => Yii::t('app\attribute', 'role'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 为权限添加权限
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addPermissionsPermissions($param)
    {
        // 表单模型实例化
        $form = new self();
        // 场景定义
        $form->setScenario('add-permissions-permissions');
        // 验证数据是否合法
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $form->getAttributes();

            $auth = Yii::$app->getAuthManager();
            $permission = $auth->createPermission($attributes['permissions']);
            $child_permissions = $auth->createPermission($attributes['child_permissions']);
            if ($auth->addChild($permission, $child_permissions)) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $form->getFirstError());
        }
    }

}