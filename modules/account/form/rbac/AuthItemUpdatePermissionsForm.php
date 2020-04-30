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
 * Class AuthItemUpdatePermissionsForm
 * @package account\form\rbac
 */
class AuthItemUpdatePermissionsForm extends Model
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
            [['name', 'description', 'rule_name', 'data'], 'safe', 'on' => 'update-permissions'],
            [['name', 'description', 'rule_name', 'data'], 'string', 'on' => 'update-permissions'],
            [['name', 'description'], 'required', 'on' => 'update-permissions'],
            [['name'], 'trim', 'on' => 'update-permissions'],
            [['rule_name'], 'validateRuleName', 'when' => function($model){
                return !$model->hasErrors();
            } , 'skipOnEmpty' => false, 'on' => 'update-permissions'],
            [['name'], 'validateName', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'update-permissions'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'update-permissions' => [
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
        $appRoutes = (new AppRoutes())->getAppRoutes();
        if (!ArrayHelper::isIn($this->$attribute, $appRoutes)) {
            $this->addError($attribute, Yii::t('app/error', 'permissions name error'));
            return;
        }

        $auth = Yii::$app->getAuthManager();
        // 权限是否存在
        $permission = $auth->getPermission($this->name);
        if(empty($permission)){
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
    public static function updatePermissions($param)
    {
        // 表单模型实例化
        $authItemUpdatePermissionsForm = new AuthItemUpdatePermissionsForm();
        // 场景定义
        $authItemUpdatePermissionsForm->setScenario('update-permissions');
        // 验证数据是否合法
        if ($authItemUpdatePermissionsForm->load([$authItemUpdatePermissionsForm->formName() => $param]) && $authItemUpdatePermissionsForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemUpdatePermissionsForm->getAttributes();

            $auth = Yii::$app->getAuthManager();
            $permission = $auth->createPermission($attributes['name']);
            $permission->description = $attributes['description'];
            $permission->ruleName = $attributes['rule_name'];
            $permission->data = $attributes['data'];
            if ($auth->update($attributes['name'], $permission)) {
                throw new HttpException(200, Yii::t('app/success', 'data update successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemUpdatePermissionsForm->getFirstError());
        }
    }

}
