<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\user;

use account\form\Model;
use app\models\User;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class LogoutForm
 * @package account\form
 */
class LogoutForm extends Model
{
    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'logout' => [
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
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 退出登录
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public static function logout($param)
    {
        $logoutForm = new LogoutForm();
        $logoutForm->setScenario('logout');
        if ($logoutForm->load([$logoutForm->formName() => $param]) && $logoutForm->validate()) {
            User::logout();
            throw new HttpException(200, Yii::t('app/success', 'logout successfully'));
        } else {
            throw new HttpException(422, $logoutForm->getFirstError());
        }
    }

    /***************************** 获取数据 *********************************/

}