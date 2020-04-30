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
 * Class AuthItemAddRolePermissionsForm
 * @package account\form\rbac
 */
class AuthItemAddRolePermissionsForm extends Model
{
    public $name;
    public $role;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'role'], 'safe', 'on' => 'add-role-permissions'],
            [['name', 'role'], 'required', 'on' => 'add-role-permissions'],
            [['name', 'role'], 'trim', 'on' => 'add-role-permissions'],
            [['name', 'role'], 'string', 'on' => 'add-role-permissions'],
            [['name'], 'validateNameAndRole', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'add-role-permissions']
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'add-role-permissions' => [
                'name',
                'role'
            ]
        ];
    }

    /**
     * 验证权限、角色关系是否合法
     * @param $attribute
     * @param $params
     */
    public function validateNameAndRole($attribute, $params)
    {
        $auth = Yii::$app->getAuthManager();
        // 权限是否存在
        $permission = $auth->getPermission($this->name);
        if(empty($permission)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }

        // 角色是否存在
        $role = $auth->getRole($this->role);
        if(empty($role)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }

        // 确认关系是否存在
        if($auth->hasChild($role, $permission) == true){
            $this->addError($attribute, Yii::t('app/error', 'the data exist'));
            return;
        }

        // 验证权限、角色关系是否合法
        $role = $auth->createRole($this->role);
        $permission = $auth->createPermission($this->name);
        if (!$auth->canAddChild($role, $permission)) {
            $this->addError($attribute, Yii::t('app/error', 'role or name error'));
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
     * 为角色添加权限
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addRolePermissions($param)
    {
        // 表单模型实例化
        $authItemAddRolePermissionsForm = new AuthItemAddRolePermissionsForm();
        // 场景定义
        $authItemAddRolePermissionsForm->setScenario('add-role-permissions');
        // 验证数据是否合法
        if ($authItemAddRolePermissionsForm->load([$authItemAddRolePermissionsForm->formName() => $param]) && $authItemAddRolePermissionsForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAddRolePermissionsForm->getAttributes();

            $auth = Yii::$app->getAuthManager();
            $permission = $auth->createRole($attributes['name']);
            $role = $auth->createRole($attributes['role']);
            if ($auth->addChild($role, $permission)) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAddRolePermissionsForm->getFirstError());
        }
    }

}