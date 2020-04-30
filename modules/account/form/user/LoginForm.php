<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\user;

use account\form\Model;
use account\redis\SmsCode;
use app\extensions\Wxapp;
use app\models\User;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class LoginForm
 * @package account\form
 */
class LoginForm extends Model
{
    /** @var User $_user 保存用户数据容器，避免多次查询 */
    private static $_user = null;

    public $mobile;
    public $password;
    public $captcha;
    public $verify_code;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['mobile', 'password', 'captcha', 'verify_code'], 'safe', 'on' => 'login'],
            [['mobile', 'password', 'captcha', 'verify_code'], 'trim', 'on' => 'login'],
            [['mobile', 'img_captcha'], 'required', 'on' => 'login'],
            [['mobile'], 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/', 'on' => 'login'],
            [['verify_code'], 'captcha', 'captchaAction'=>'account/site/captcha', 'on' => 'login'],
            [['password'], 'required', 'when' => function ($model) {
                return empty($model->captcha);
            }, 'on' => 'login'],
            [['captcha'], 'required', 'when' => function ($model) {
                return empty($model->password);
            }, 'on' => 'login'],
            [['captcha'], 'validateCaptcha', 'when' => function ($model) {
                return !$model->hasErrors() && !empty($model->captcha);
            }, 'on' => 'login'],
            [['mobile'], 'validateMobile', 'when' => function ($model) {
                return !$model->hasErrors();
            }, 'on' => 'login'],
            [['password'], 'validatePassword', 'when' => function ($model) {
                return !$model->hasErrors() && !empty($model->password);
            }, 'on' => 'login'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'login' => [
                'mobile',
                'password',
                'captcha',
                'verify_code',
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
            'mobile' => Yii::t('app\attribute', 'username'),
            'password' => Yii::t('app\attribute', 'password'),
            'captcha' => Yii::t('app\attribute', 'captcha'),
            'verify_code' => Yii::t('app\attribute', 'verify_code'),
        ];
    }

    /**
     * 验证用户名是否合法
     * @param $attribute
     * @param $params
     * @throws \Exception
     * @throws \Throwable
     */
    public function validateMobile($attribute, $params)
    {
        $user = self::getUser($this->mobile);
        if (empty($user)) {
            $this->addError($attribute, Yii::t('app/error', 'the user does not exist'));
            return;
        }

        // 确认用户是否被冻结
        if ($user->getAttribute('is_able') == user::IS_NOT_ABLE) {
            $this->addError($attribute, Yii::t('app/error', 'the user is freeze'));
            return;
        }
    }

    /**
     * 验证用户密码是否合法
     * @param $attribute
     * @param $params
     * @throws \Exception
     * @throws \Throwable
     */
    public function validatePassword($attribute, $params)
    {
        $user = self::getUser($this->mobile);
        if (!empty($user) && !$user->validatePassword($this->password)) {
            $this->addError($attribute, Yii::t('app/error', 'user password error'));
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
     * 用户登录
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function login($param)
    {
        $loginForm = new LoginForm();
        $loginForm->setScenario('login');
        if ($loginForm->load([$loginForm->formName() => $param]) && $loginForm->validate()) {
            $attributes = $loginForm->getAttributes();
            //登录操作
            return User::login($attributes['mobile']);
        } else {
            throw new HttpException(422, $loginForm->getFirstError());
        }
    }

    /***************************** 获取数据 *********************************/

    /**
     * 通过用户手机号获取用户信息
     * @param $mobile
     * @param bool $ignoreExistingData 无视容器已有的数据
     * @return User
     * @throws \Exception
     * @throws \Throwable
     */
    private static function getUser($mobile, $ignoreExistingData = false)
    {
        if (empty(static::$_user) || $ignoreExistingData === true) {
            static::$_user = User::findIdentityByMobile($mobile);
        }
        return static::$_user;
    }
}