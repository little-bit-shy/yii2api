<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\sms;

use account\form\Model;
use account\redis\SmsCode;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class SmsCodeForm
 * @package account\form
 */
class SmsCodeForm extends Model
{
    public $mobile;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['mobile'], 'safe', 'on' => 'send'],
            [['mobile'], 'trim', 'on' => 'send'],
            [['mobile'], 'required', 'on' => 'send', 'message' => '{attribute}' . Yii::t('app\error', 'not null')],
            [['mobile'], 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/', 'on' => 'send'],
            [['mobile'], 'validateMobile', 'when' => function ($model) {
                return !$model->hasErrors();
            }, 'on' => 'send']
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'send' => [
                'mobile',
            ]
        ];
    }

    /**
     * 验证手机号是否合法
     * @param $attribute
     * @param $params
     */
    public function validateMobile($attribute, $params)
    {
        $time = time();
        // 获取手机验证码发送间隔时间
        $interval = Yii::$app->params['cacheKeyPrefix']['smsCode']['interval'];
        $smsCode = SmsCode::findMobile($this->$attribute);
        if (!empty($smsCode)) {
            if (($time - $smsCode['send_at']) < $interval) {
                $this->addError($attribute, Yii::t('app/error', 'verification code sent too often, please send again later'));
                return;
            }
        }
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'mobile' => Yii::t('app\attribute', 'phone'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 手机验证码发送
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function smsCode($param)
    {
        $logoutForm = new SmsCodeForm();
        $logoutForm->setScenario('send');
        if ($logoutForm->load([$logoutForm->formName() => $param]) && $logoutForm->validate()) {
            $attributes = $logoutForm->getAttributes();
            SmsCode::createSmsCode($attributes['mobile']);
            throw new HttpException(200, Yii::t('app/success', 'sms send successfully'));
        } else {
            throw new HttpException(422, $logoutForm->getFirstError());
        }
    }

    /***************************** 获取数据 *********************************/

}