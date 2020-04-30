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
 * Class ForgetForm
 * @package account\form
 */
class ForgetForm extends Model
{
    /** @var User $_user 保存用户数据容器，避免多次查询 */
    private static $_user = null;

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
            [['mobile', 'password', 'captcha'], 'safe', 'on' => 'forget'],
            [['mobile', 'password', 'captcha'], 'required', 'on' => 'forget', 'message' => '{attribute}' . Yii::t('app\error', 'not null')],
            [['mobile', 'captcha'], 'string', 'on' => 'forget'],
            [['mobile', 'password', 'captcha'], 'trim', 'on' => 'forget'],
            [['password'], 'string', 'max' => 22, 'min' => 6, 'on' => 'forget'],
            [['password'], 'match', 'pattern' => '/^[a-z0-9\-_]+$/', 'on' => 'forget'],
            [['mobile'], 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/', 'on' => 'forget'],
            [['captcha'], 'validateCaptcha', 'when' => function ($model) {
                return !$model->hasErrors() && !empty($model->captcha);
            }, 'on' => 'forget'],
            [['mobile'], 'validateMobile', 'when' => function ($model) {
                return !$model->hasErrors();
            }, 'on' => 'forget'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'forget' => [
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
            'mobile' => Yii::t('app\attribute', 'username'),
            'password' => Yii::t('app\attribute', 'password'),
            'captcha' => Yii::t('app\attribute', 'captcha'),
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
     * 密码重置
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function forget($param)
    {
        $forgetForm = new ForgetForm();
        $forgetForm->setScenario('forget');
        if ($forgetForm->load([$forgetForm->formName() => $param]) && $forgetForm->validate()) {
            $attributes = $forgetForm->getAttributes();
            $time = time();
            $password = Yii::$app->getSecurity()->generatePasswordHash($attributes['password']);
            // 密码重置
            if (User::ResetPswMobile($attributes['mobile'], $password)) {
                throw new HttpException(200, Yii::t('app/success', 'password reset successful'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            throw new HttpException(422, $forgetForm->getFirstError());
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
    private function getUser($mobile, $ignoreExistingData = false)
    {
        if (empty(static::$_user) || $ignoreExistingData === true) {
            static::$_user = User::findIdentityByMobile($mobile);
        }
        return static::$_user;
    }
}