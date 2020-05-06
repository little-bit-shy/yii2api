<?php
namespace account\rules;

use yii\rbac\Rule;

/**
 * 超级管理员的权限分配不允许删除
 */
class DemoRule extends Rule
{

    /**
     * @param string|integer $user 用户 ID.
     * @param Item $item 该规则相关的角色或者权限
     * @param array $params 传给 ManagerInterface::checkAccess() 的参数
     * @return boolean 代表该规则相关的角色或者权限是否被允许
     */
    public function execute($user, $item, $params)
    {
        return 1 != 1;
    }
}