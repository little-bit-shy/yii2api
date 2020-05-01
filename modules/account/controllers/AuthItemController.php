<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: 权限、角色数据相关控制器
 */

namespace account\controllers;

use account\form\rbac\AuthItemAddPermissionsPermissionsForm;
use account\form\rbac\AuthItemAddRoleRoleForm;
use account\form\rbac\AuthItemAllListWithPermissionsForm;
use account\form\rbac\AuthItemAllRoleWithRoleForm;
use account\form\rbac\AuthItemDeletePermissionsPermissionsForm;
use account\form\rbac\AuthItemDeleteRoleRoleForm;
use account\form\rbac\AuthItemRemoveRoleForm;
use account\form\rbac\AuthItemUpdateRoleForm;
use app\components\AppRoutes;
use account\form\rbac\AuthItemAddPermissionsForm;
use account\form\rbac\AuthItemAddRoleForm;
use account\form\rbac\AuthItemAddRolePermissionsForm;
use account\form\rbac\AuthItemAddUserForm;
use account\form\rbac\AuthItemAddUserRoleForm;
use account\form\rbac\AuthItemAllListsWithLevelForm;
use account\form\rbac\AuthItemAllListsWithRoleForm;
use account\form\rbac\AuthItemAllRoleWithUserForm;
use account\form\rbac\AuthItemDeleteRolePermissionsForm;
use account\form\rbac\AuthItemDeleteUserRoleForm;
use account\form\rbac\AuthItemIndexForm;
use account\form\rbac\AuthItemRemovePermissionsForm;
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
            'index' => ['GET', 'POST'],
            'all-lists' => ['GET', 'POST'],
            'project-directory' => ['GET', 'POST'],
            'add-permissions' => ['POST'],
            'remove-permissions' => ['POST'],
            'update-permissions' => ['POST'],
            'all-lists-with-level' => ['GET', 'POST'],
            'all-lists-with-role' => ['GET', 'POST'],
            'all-lists-with-permissions' => ['GET', 'POST'],
            'add-role' => ['POST'],
            'update-role' => ['POST'],
            'remove-role' => ['POST'],
            'add-role-permissions' => ['POST'],
            'delete-role-permissions' => ['POST'],
            'add-permissions-permissions' => ['POST'],
            'delete-permissions-permissions' => ['POST'],
            'user-lists' => ['GET', 'POST'],
            'add-user-role' => ['POST'],
            'delete-user-role' => ['POST'],
            'all-role-with-user' => ['GET', 'POST'],
            'add-user' => ['POST'],
            'all-role-with-role' => ['GET', 'POST'],
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
     * 返回权限下的所有权限列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllListsWithPermissions()
    {
        return AuthItemAllListWithPermissionsForm::allListsWithPermissions($this->getParams());
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
     * 修改角色
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionUpdateRole()
    {
        return AuthItemUpdateRoleForm::updateRole($this->getParams());
    }

    /**
     * 删除角色
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionRemoveRole()
    {
        return AuthItemRemoveRoleForm::removeRole($this->getParams());
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
     * 为权限添加的权限
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddPermissionsPermissions()
    {
        return AuthItemAddPermissionsPermissionsForm::addPermissionsPermissions($this->getParams());
    }

    /**
     * 为权限删除权限
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     *
     */
    public function actionDeletePermissionsPermissions()
    {
        return AuthItemDeletePermissionsPermissionsForm::deletePermissionsPermissions($this->getParams());
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
     * 添加用户数据
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddUser()
    {
        return AuthItemAddUserForm::addUser($this->getParams());
    }
}