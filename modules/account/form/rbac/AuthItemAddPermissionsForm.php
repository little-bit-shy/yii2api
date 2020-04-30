<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\rbac;

use app\components\AppRoutes;
use account\form\Model;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAddPermissionsForm
 * @package account\form\rbac
 */
class AuthItemAddPermissionsForm extends Model
{
    public $name;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe', 'on' => 'add-permissions'],
            [['name'], 'required', 'on' => 'add-permissions'],
            [['name'], 'trim', 'on' => 'add-permissions'],
            [['name'], 'string', 'on' => 'add-permissions'],
            [['name'], 'validateName', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'add-permissions'],
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
        if(!empty($permission)){
            $this->addError($attribute, Yii::t('app/error', 'the data exist'));
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
            'add-permissions' => [
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
     * 添加权限
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addPermissions($param)
    {
        // 表单模型实例化
        $authItemAddPermissionsForm = new AuthItemAddPermissionsForm();
        // 场景定义
        $authItemAddPermissionsForm->setScenario('add-permissions');
        // 验证数据是否合法
        if ($authItemAddPermissionsForm->load([$authItemAddPermissionsForm->formName() => $param]) && $authItemAddPermissionsForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAddPermissionsForm->getAttributes();
            $auth = Yii::$app->getAuthManager();
            $permission = $auth->createPermission($attributes['name']);
            $permission->description = $attributes['name'];
            if ($auth->add($permission)) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAddPermissionsForm->getFirstError());
        }
    }

}