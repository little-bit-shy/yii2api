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
 * Class AuthItemAddUserRoleForm
 * @package account\form\rbac
 */
class AuthItemAddUserRoleForm extends Model
{
    public $user_id;
    public $role;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'role'], 'safe', 'on' => 'add-user-role'],
            [['user_id', 'role'], 'required', 'on' => 'add-user-role'],
            [['role'], 'trim', 'on' => 'add-user-role'],
            [['user_id'], 'integer', 'on' => 'add-user-role'],
            [['role'], 'string', 'on' => 'add-user-role'],
            [['user_id'], 'validateUserIdAndRole', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'add-user-role']
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'add-user-role' => [
                'user_id',
                'role'
            ]
        ];
    }

    /**
     * 验证用户、角色关系是否合法
     * @param $attribute
     * @param $params
     */
    public function validateUserIdAndRole($attribute, $params)
    {
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getRole($this->role);

        if(empty($role)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }
        $roles = $auth->getAssignments($this->user_id);
        if(isset($roles[$this->role])){
            $this->addError($attribute, Yii::t('app/error', 'the data exist'));
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
            'user_id' => Yii::t('app\attribute', 'user_id'),
            'role' => Yii::t('app\attribute', 'role'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 为用户分配角色
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addUserRole($param)
    {
        // 表单模型实例化
        $authItemAddUserRoleForm = new AuthItemAddUserRoleForm();
        // 场景定义
        $authItemAddUserRoleForm->setScenario('add-user-role');
        // 验证数据是否合法
        if ($authItemAddUserRoleForm->load([$authItemAddUserRoleForm->formName() => $param]) && $authItemAddUserRoleForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAddUserRoleForm->getAttributes();
            $auth = Yii::$app->getAuthManager();
            $role = $auth->createRole($attributes['role']);
            if ($auth->assign($role, $attributes['user_id'])) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAddUserRoleForm->getFirstError());
        }
    }

}