<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\rbac;

use account\form\Model;
use account\models\User;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAddUserForm
 * @package account\form\rbac
 */
class AuthItemAddUserForm extends Model
{
    public $mobile;
    public $account;
    public $password;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['mobile', 'account', 'password'], 'safe', 'on' => 'add-user'],
            [['mobile', 'account', 'password'], 'trim', 'on' => 'add-user'],
            [['mobile'], 'filter', 'filter' => function ($value) {
                return $value ?: null;
            }, 'on' => 'add-user'],
            [['account', 'mobile', 'password'], 'required', 'on' => 'add-user'],
            [['password'], 'filter', 'filter' => function ($value) {
                return Yii::$app->getSecurity()->generatePasswordHash($value);
            }, 'on' => 'add-user'],
            [['mobile', 'account', 'password'], 'string', 'on' => 'add-user'],
            [['mobile'], 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/', 'on' => 'add-user'],
            [['mobile', 'account'], 'unique', 'targetClass' => User::className(), 'on' => 'add-user'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'add-user' => [
                'mobile', 'account', 'password'
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
            'mobile' => Yii::t('app\attribute', 'phone'),
            'account' => Yii::t('app\attribute', 'username'),
            'password' => Yii::t('app\attribute', 'password'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 添加用户
     * @param $param
     * @throws HttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addUser($param)
    {
        // 表单模型实例化
        $authItemAddUserForm = new AuthItemAddUserForm();
        // 场景定义
        $authItemAddUserForm->setScenario('add-user');
        // 验证数据是否合法
        if ($authItemAddUserForm->load([$authItemAddUserForm->formName() => $param]) && $authItemAddUserForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAddUserForm->getAttributes();
            // 添加用户
            if (User::addUser($attributes['account'], $attributes['password'], $attributes['mobile'])) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAddUserForm->getFirstError());
        }
    }
}
