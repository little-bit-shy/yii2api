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
 * Class AuthItemAddRoleRoleForm
 * @package account\form\rbac
 */
class AuthItemAddRoleRoleForm extends Model
{
    public $role;
    public $child_role;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['role', 'child_role'], 'safe', 'on' => 'add-role-role'],
            [['role', 'child_role'], 'required', 'on' => 'add-role-role'],
            [['role', 'child_role'], 'trim', 'on' => 'add-role-role'],
            [['role', 'child_role'], 'string', 'on' => 'add-role-role'],
            [['role'], 'validateRole', 'when' => function($model){
                return !$model->hasErrors();
            } ,'on' => 'add-role-role']
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'add-role-role' => [
                'role',
                'child_role'
            ]
        ];
    }

    /**
     * 验证角色、角色关系是否合法
     * @param $attribute
     * @param $params
     */
    public function validateRole($attribute, $params)
    {
        $auth = Yii::$app->getAuthManager();

        $parent = $auth->getRole($this->role);
        if(empty($parent)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }
        $child = $auth->getRole($this->child_role);
        if(empty($child)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }

        // 是否已存在该数据
        if ($auth->hasChild($parent, $child)) {
            $this->addError($attribute, Yii::t('app/error', 'the data exist'));
            return;
        }

        // 能否添加该数据
        if (!$auth->canAddChild($parent, $child)) {
            $this->addError($attribute, Yii::t('app/error', 'the role could not be added'));
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
            'role' => Yii::t('app\attribute', 'role'),
            'child_role' => Yii::t('app\attribute', 'child_role'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 为角色分配角色
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addRoleRole($param)
    {
        // 表单模型实例化
        $authItemAddRoleRoleForm = new AuthItemAddRoleRoleForm();
        // 场景定义
        $authItemAddRoleRoleForm->setScenario('add-role-role');
        // 验证数据是否合法
        if ($authItemAddRoleRoleForm->load([$authItemAddRoleRoleForm->formName() => $param]) && $authItemAddRoleRoleForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAddRoleRoleForm->getAttributes();

            $auth = Yii::$app->getAuthManager();
            $parent = $auth->getRole($attributes['role']);
            $child = $auth->getRole($attributes['child_role']);
            if ($auth->addChild($parent, $child)) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAddRoleRoleForm->getFirstError());
        }
    }

}