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
use account\redis\SmsCode;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class RegisteredForm
 * @package account\form
 */
class RegisteredForm extends Model
{
    public $mobile;
    public $password;
    public $captcha;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['mobile', 'password', 'captcha'], 'safe', 'on' => 'registered'],
            [['mobile', 'password', 'captcha'], 'trim', 'on' => 'registered'],
            [['mobile', 'password', 'captcha'], 'required', 'on' => 'registered', 'message' => '{attribute}' . Yii::t('app\error', 'not null')],
            [['mobile'], 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/', 'on' => 'registered'],
            [['password'], 'string', 'max' => 22, 'min' => 6, 'on' => 'registered'],
            [['password'], 'match', 'pattern' => '/^[a-z0-9\-_]+$/', 'on' => 'registered'],
            [['captcha'], 'validateCaptcha', 'when' => function ($model) {
                return !$model->hasErrors();
            }, 'on' => 'registered'],
            [['mobile'], 'validateMobile', 'when' => function ($model) {
                return !$model->hasErrors();
            }, 'on' => 'registered'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'registered' => [
                'mobile',
                'password',
                'captcha',
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
            'mobile' => Yii::t('app\attribute', 'mobile'),
            'password' => Yii::t('app\attribute', 'password'),
            'captcha' => Yii::t('app\attribute', 'captcha'),
        ];
    }

    /**
     * 验证手机号是否合法
     * @param $attribute
     * @param $params
     * @throws \Exception
     * @throws \Throwable
     */
    public function validateMobile($attribute, $params)
    {
        $user = User::findIdentityByMobile($this->$attribute);
        if (!empty($user)) {
            $this->addError($attribute, Yii::t('app/error', 'the current phone number has been registered'));
            return;
        }
    }

    /**
     * 验证验证码是否合法
     * @param $attribute
     * @param $params
     * @throws \Exception
     * @throws \Throwable
     */
    public function validateCaptcha($attribute, $params)
    {
        $smsCode = SmsCode::findMobile($this->mobile, $this->captcha);
        if (empty($smsCode) || ($smsCode['sms_code'] != $this->captcha)) {
            $this->addError($attribute, Yii::t('app/error', 'verification code error'));
            return;
        }
    }

    /***************************** 表单操作 *********************************/

    /**
     * 用户注册
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function registered($param)
    {
        $registeredForm = new RegisteredForm();
        $registeredForm->setScenario('registered');
        if ($registeredForm->load([$registeredForm->formName() => $param]) && $registeredForm->validate()) {
            $attributes = $registeredForm->getAttributes();
            $password = Yii::$app->getSecurity()->generatePasswordHash($attributes['password']);
            // 账号注册
            if (User::addUser(
                Yii::t('app/message', 'default name'),
                $password,$attributes['mobile'])) {
                throw new HttpException(200, Yii::t('app/success', 'user registration successful'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            throw new HttpException(422, $registeredForm->getFirstError());
        }
    }

    /***************************** 获取数据 *********************************/

}