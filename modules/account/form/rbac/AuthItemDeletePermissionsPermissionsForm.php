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
 * Class AuthItemDeletePermissionsPermissionsForm
 * @package account\form\rbac
 */
class AuthItemDeletePermissionsPermissionsForm extends Model
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
            [['permissions', 'child_permissions'], 'safe', 'on' => 'delete-permissions-permissions'],
            [['permissions', 'child_permissions'], 'required', 'on' => 'delete-permissions-permissions'],
            [['permissions', 'child_permissions'], 'trim', 'on' => 'delete-permissions-permissions'],
            [['permissions', 'child_permissions'], 'string', 'on' => 'delete-permissions-permissions'],
            [['permissions'], 'validatePermissions', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'delete-permissions-permissions'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'delete-permissions-permissions' => [
                'permissions',
                'child_permissions'
            ]
        ];
    }

    /**
     * 验证角色、角色关系是否合法
     * @param $attribute
     * @param $params
     */
    public function validatePermissions($attribute, $params)
    {
        $auth = Yii::$app->getAuthManager();
        $parent = $auth->getPermission($this->permissions);
        if(empty($parent)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }
        $child = $auth->getPermission($this->child_permissions);
        if(empty($child)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }

        // 是否已存在该数据
        if(!$auth->hasChild($parent, $child)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
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
            'permissions' => Yii::t('app\attribute', 'permissions'),
            'child_permissions' => Yii::t('app\attribute', 'child_permissions'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 为权限删除权限
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function deletePermissionsPermissions($param)
    {
        // 表单模型实例化
        $form = new self();
        // 场景定义
        $form->setScenario('delete-permissions-permissions');
        // 验证数据是否合法
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $form->getAttributes();

            $auth = Yii::$app->getAuthManager();
            $parent = $auth->getPermission($attributes['permissions']);
            $child = $auth->getPermission($attributes['child_permissions']);
            if ($auth->removeChild($parent, $child)) {
                throw new HttpException(200, Yii::t('app/success', 'data delete successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $form->getFirstError());
        }
    }

}