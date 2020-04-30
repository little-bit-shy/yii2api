<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\rbac;

use app\components\ArrayHelper;
use account\form\Model;
use Yii;

/**
 * 表单模型
 * Class AllPermissionsForm
 * @package account\form\rbac
 */
class AllPermissionsForm extends Model
{
    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 获取当前用户所有的权限
     * @param $param
     * @return mixed
     * @throws \Throwable
     */
    public static function allPermissions($param)
    {
        // 获取默认角色拥有的权限
        $defaultRoles = Yii::$app->params['defaultRoles'];
        $userId = Yii::$app->getUser()->getId();
        $auth = Yii::$app->getAuthManager();
        $permissions = [];
        foreach ($defaultRoles as $defaultRole) {
            $permissions = ArrayHelper::merge($permissions, $auth->getPermissionsByRole($defaultRole));
        }
        $permissions = ArrayHelper::merge($permissions, $auth->getPermissionsByUser($userId));
        return $permissions;
    }
}