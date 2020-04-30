<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\user;

use account\form\Model;
use account\models\User;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class ResetPswForm
 * @package account\form\rbac
 */
class ResetPswForm extends Model
{
    /** @var User $_user 保存用户数据容器，避免多次查询 */
    private static $_user = null;

    public $password_old;
    public $password_new;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['password_old', 'password_new'], 'safe', 'on' => 'reset-psw'],
            [['password_old', 'password_new'], 'required', 'on' => 'reset-psw'],
            [['password_old', 'password_new'], 'string', 'on' => 'reset-psw'],
            [['password_old', 'password_new'], 'trim', 'on' => 'reset-psw'],
            [['password_new'], 'filter', 'filter' => function ($value) {
                return Yii::$app->getSecurity()->generatePasswordHash($value);
            }, 'on' => 'reset-psw'],
            [['password_old'], 'validatePasswordOld', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'reset-psw'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'reset-psw' => [
                'password_old', 'password_new'
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
            'password_old' => Yii::t('app\attribute', 'password_old'),
            'password_new' => Yii::t('app\attribute', 'password_new'),
        ];
    }

    /**
     * 验证用户密码是否合法
     * @param $attribute
     * @param $params
     * @throws \Exception
     * @throws \Throwable
     */
    public function validatePasswordOld($attribute, $params)
    {
        $user = self::getUser(Yii::$app->getUser()->getId());
        if (empty($user)) {
            $this->addError($attribute, Yii::t('app/error', 'the user not exist'));
            return;
        } else if (!$user->validatePassword($this->password_old)) {
            $this->addError($attribute, Yii::t('app/error', 'user old password error'));
            return;
        }
    }

    /***************************** 表单操作 *********************************/

    /**
     * 重置用户密码
     * @param $param
     * @throws HttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function resetPsw($param)
    {
        // 表单模型实例化
        $resetPswForm = new ResetPswForm();
        // 场景定义
        $resetPswForm->setScenario('reset-psw');
        // 验证数据是否合法
        if ($resetPswForm->load([$resetPswForm->formName() => $param]) && $resetPswForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $resetPswForm->getAttributes();
            // 添加用户
            if (User::ResetPsw(Yii::$app->getUser()->getId(), $attributes['password_new'])) {
                throw new HttpException(200, Yii::t('app/success', 'password reset successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $resetPswForm->getFirstError());
        }
    }

    /***************************** 获取数据 *********************************/

    /**
     * 通过用户名称获取用户信息
     * @param $id
     * @param bool $ignoreExistingData 无视容器已有的数据
     * @return User
     * @throws \Exception
     * @throws \Throwable
     */
    private function getUser($id, $ignoreExistingData = false)
    {
        if (empty(static::$_user) || $ignoreExistingData === true) {
            static::$_user = \app\models\User::findIdentityById($id);
        }
        return static::$_user;
    }
}
