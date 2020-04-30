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
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAllListsWithLevelForm
 * @package account\form\rbac
 */
class AuthItemAllListsWithLevelForm extends Model
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
        return parent::scenarios();
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
     * 返回所有列表数据（数据重构后添加了层次结构）
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function allListsWithLevel($param)
    {
        $auth = Yii::$app->getAuthManager();
        // 获取数据
        $dataProvider = ArrayHelper::toArray($auth->getPermissions());
        // 数据重构（增加层次结构）
        return ArrayHelper::menu($dataProvider, 'name');
    }
}