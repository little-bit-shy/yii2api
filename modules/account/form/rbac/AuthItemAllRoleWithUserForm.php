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
 * Class AuthItemAllRoleWithUserForm
 * @package account\form\rbac
 */
class AuthItemAllRoleWithUserForm extends Model
{
    public $user_id;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id'], 'safe', 'on' => 'all-role-with-user'],
            [['user_id'], 'required', 'on' => 'all-role-with-user'],
            [['user_id'], 'integer', 'on' => 'all-role-with-user'],

        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'all-role-with-user' => [
                'user_id',
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
            'user_id' => Yii::t('app\attribute', 'user_id'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 返回用户下的所有角色列表数据
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function allRoleWithUser($param)
    {
        // 表单模型实例化
        $authItemAllRoleWithUserForm = new AuthItemAllRoleWithUserForm();
        // 场景定义
        $authItemAllRoleWithUserForm->setScenario('all-role-with-user');
        // 验证数据是否合法
        if ($authItemAllRoleWithUserForm->load([$authItemAllRoleWithUserForm->formName() => $param]) && $authItemAllRoleWithUserForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAllRoleWithUserForm->getAttributes();
            // 获取数据
            $auth = Yii::$app->getAuthManager();
            return $auth->getAssignments($attributes['user_id']);
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAllRoleWithUserForm->getFirstError());
        }
    }
}