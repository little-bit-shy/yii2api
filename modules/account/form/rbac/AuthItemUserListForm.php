<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\rbac;

use account\form\Model;
use account\models\User;

/**
 * 表单模型
 * Class AuthItemUserListForm
 * @package account\form\rbac
 */
class AuthItemUserListForm extends Model
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

    /***************************** 获取数据 *********************************/

    /**
     * 获取列表数据
     * @param $param
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function lists($param)
    {
        $dataProvider = User::lists();
        return $dataProvider;
    }
}