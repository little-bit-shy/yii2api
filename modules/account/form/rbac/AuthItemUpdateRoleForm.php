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
 * Class AuthItemUpdateRoleForm
 * @package account\form\rbac
 */
class AuthItemUpdateRoleForm extends Model
{
    public $name;
    public $description;
    public $rule_name;
    public $data;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'description', 'rule_name', 'data'], 'safe', 'on' => 'update-role'],
            [['name', 'description', 'rule_name', 'data'], 'string', 'on' => 'update-role'],
            [['name', 'description'], 'required', 'on' => 'update-role'],
            [['name'], 'trim', 'on' => 'update-role'],
            [['rule_name'], 'validateRuleName', 'when' => function($model){
                return !$model->hasErrors();
            } , 'skipOnEmpty' => false, 'on' => 'update-role'],
            [['name'], 'validateName', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'update-role'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'update-role' => [
                'name', 'description', 'rule_name', 'data'
            ]
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
     * 验证rule_name参数是否合法
     * @param $attribute
     * @param $params
     */
    public function validateRuleName($attribute, $params)
    {
        if ($this->$attribute !== null && !(class_exists($this->$attribute) && is_subclass_of($this->$attribute, '\yii\rbac\Rule'))) {
            $this->addError($attribute, Yii::t('app/error', 'rule name error'));
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
            'description' => Yii::t('app\attribute', 'description'),
            'rule_name' => Yii::t('app\attribute', 'rule_name'),
            'data' => Yii::t('app\attribute', 'data'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 修改权限
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function updateRole($param)
    {
        // 表单模型实例化
        $authItemUpdateRoleForm = new AuthItemUpdateRoleForm();
        // 场景定义
        $authItemUpdateRoleForm->setScenario('update-role');
        // 验证数据是否合法
        if ($authItemUpdateRoleForm->load([$authItemUpdateRoleForm->formName() => $param]) && $authItemUpdateRoleForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemUpdateRoleForm->getAttributes();

            $auth = Yii::$app->getAuthManager();
            $role = $auth->createRole($attributes['name']);
            $role->description = $attributes['description'];
            $role->ruleName = $attributes['rule_name'];
            $role->data = $attributes['data'];
            if ($auth->update($attributes['name'], $role)) {
                throw new HttpException(200, Yii::t('app/success', 'data update successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemUpdateRoleForm->getFirstError());
        }
    }

}
