<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: 权限、角色数据相关控制器
 */

namespace account\controllers;

use account\form\rbac\AuthItemAddRoleRoleForm;
use account\form\rbac\AuthItemAllRoleWithRoleForm;
use account\form\rbac\AuthItemDeleteRoleRoleForm;
use app\components\AppRoutes;
use account\form\rbac\AuthItemAddPermissionsForm;
use account\form\rbac\AuthItemAddRoleForm;
use account\form\rbac\AuthItemAddRolePermissionsForm;
use account\form\rbac\AuthItemAddUserForm;
use account\form\rbac\AuthItemAddUserRoleForm;
use account\form\rbac\AuthItemAllListsForm;
use account\form\rbac\AuthItemAllListsWithLevelForm;
use account\form\rbac\AuthItemAllListsWithRoleForm;
use account\form\rbac\AuthItemAllRoleWithUserForm;
use account\form\rbac\AuthItemDeleteRolePermissionsForm;
use account\form\rbac\AuthItemDeleteUserRoleForm;
use account\form\rbac\AuthItemIndexForm;
use account\form\rbac\AuthItemRemovePermissionsForm;
use account\form\rbac\AuthItemResetPswUserForm;
use account\form\rbac\AuthItemUpdatePermissionsForm;
use account\form\rbac\AuthItemUserListForm;
use app\controllers\behaviors\QueryParamAuth;

class AuthItemController extends Controller
{
    /**
     * 定义相关行为
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'optional' => []
        ];
        return $behaviors;
    }

    /**
     * 访问方法设置
     * @return array
     */
    protected function verbs()
    {
        return [
            'index' => ['POST'],
            'all-lists' => ['POST'],
            'project-directory' => ['POST'],
            'add-permissions' => ['POST'],
            'remove-permissions' => ['POST'],
            'update-permissions' => ['POST'],
            'all-lists-with-level' => ['POST'],
            'all-lists-with-role' => ['POST'],
            'add-role' => ['POST'],
            'add-role-permissions' => ['POST'],
            'delete-role-permissions' => ['POST'],
            'user-lists' => ['POST'],
            'add-user-role' => ['POST'],
            'delete-user-role' => ['POST'],
            'all-role-with-user' => ['POST'],
            'add-user' => ['POST'],
            'reset-psw-user' => ['POST'],
            'all-role-with-role' => ['POST'],
            'add-role-role' => ['POST'],
            'delete-role-role' => ['POST'],
        ];
    }

    /**
     * 返回权限、角色列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionIndex()
    {
        return AuthItemIndexForm::lists($this->getParams());
    }

    /**
     * 返回项目目录列表数据
     * @return array
     */
    public function actionProjectDirectory()
    {
        return (new AppRoutes())->getAppRoutes();
    }

    /**
     * 添加权限
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddPermissions()
    {
        return AuthItemAddPermissionsForm::addPermissions($this->getParams());
    }

    /**
     * 删除权限
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionRemovePermissions()
    {
        return AuthItemRemovePermissionsForm::removePermissions($this->getParams());
    }

    /**
     * 修改权限
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionUpdatePermissions()
    {
        return AuthItemUpdatePermissionsForm::updatePermissions($this->getParams());
    }

    /**
     * 返回所有权限列表数据（数据重构后添加了层次结构）
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllListsWithLevel()
    {
        return AuthItemAllListsWithLevelForm::allListsWithLevel($this->getParams());
    }

    /**
     * 返回角色下的所有权限列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllListsWithRole()
    {
        return AuthItemAllListsWithRoleForm::allListsWithRole($this->getParams());
    }

    /**
     * 添加角色
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddRole()
    {
        return AuthItemAddRoleForm::addRole($this->getParams());
    }

    /**
     * 为角色添加的权限
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddRolePermissions()
    {
        return AuthItemAddRolePermissionsForm::addRolePermissions($this->getParams());
    }

    /**
     * 为角色删除权限
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     *
     */
    public function actionDeleteRolePermissions()
    {
        return AuthItemDeleteRolePermissionsForm::deleteRolePermissions($this->getParams());
    }

    /**
     * 返回角色下的所有角色列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllRoleWithRole()
    {
        return AuthItemAllRoleWithRoleForm::allRoleWithRole($this->getParams());
    }

    /**
     * 为角色分配角色
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddRoleRole()
    {
        return AuthItemAddRoleRoleForm::addRoleRole($this->getParams());
    }

    /**
     * 删除为角色分配的角色
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionDeleteRoleRole()
    {
        return AuthItemDeleteRoleRoleForm::deleteRoleRole($this->getParams());
    }

    /** =======================余下用户相关========================= */

    /**
     * 返回用户列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUserLists()
    {
        return AuthItemUserListForm::lists($this->getParams());
    }

    /**
     * 为用户分配角色
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddUserRole()
    {
        return AuthItemAddUserRoleForm::addUserRole($this->getParams());
    }

    /**
     * 删除为用户分配的角色
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionDeleteUserRole()
    {
        return AuthItemDeleteUserRoleForm::deleteUserRole($this->getParams());
    }

    /**
     * 返回用户下的所有角色列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllRoleWithUser()
    {
        return AuthItemAllRoleWithUserForm::allRoleWithUser($this->getParams());
    }

    /**
     * 添加用户数据
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddUser()
    {
        return AuthItemAddUserForm::addUser($this->getParams());
    }

    /**
     * 重置用户密码
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionResetPswUser()
    {
        return AuthItemResetPswUserForm::resetPswUser($this->getParams());
    }
}