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
 * Class actionAllListsWithRole
 * @package account\form\rbac
 */
class AuthItemAllListsWithRoleForm extends Model
{
    public $name;
    public $user;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe', 'on' => 'all-lists-with-role'],
            [['name'], 'required', 'on' => 'all-lists-with-role'],
            [['name'], 'trim', 'on' => 'all-lists-with-role'],
            [['name'], 'string', 'on' => 'all-lists-with-role'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'all-lists-with-role' => [
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
     * 返回所有列表数据（数据重构后添加了层次结构）
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function allListsWithRole($param)
    {
        // 表单模型实例化
        $actionAllListsWithRole = new AuthItemAllListsWithRoleForm();
        // 场景定义
        $actionAllListsWithRole->setScenario('all-lists-with-role');
        // 验证数据是否合法
        if ($actionAllListsWithRole->load([$actionAllListsWithRole->formName() => $param]) && $actionAllListsWithRole->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $actionAllListsWithRole->getAttributes();
            // 获取数据
            $auth = Yii::$app->getAuthManager();
            return $auth->getPermissionsByRole($attributes['name']);
        } else {
            // 数据不合法
            throw new HttpException(422, $actionAllListsWithRole->getFirstError());
        }
    }
}