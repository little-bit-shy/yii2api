<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\rbac;

use account\form\Model;
use app\components\ArrayHelper;
use Yii;
use yii\rbac\ManagerInterface;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAllListWithPermissionsForm
 * @package account\form\rbac
 */
class AuthItemAllListWithPermissionsForm extends Model
{
    public $name;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe', 'on' => 'all-list-with-permissions'],
            [['name'], 'required', 'on' => 'all-list-with-permissions'],
            [['name'], 'string', 'on' => 'all-list-with-permissions'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'all-list-with-permissions' => [
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
     * 返回权限下的所有角色列表数据
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function allListsWithPermissions($param)
    {
        // 表单模型实例化
        $form = new self();
        // 场景定义
        $form->setScenario('all-list-with-permissions');
        // 验证数据是否合法
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $form->getAttributes();
            // 获取数据
            $auth = Yii::$app->getAuthManager();
            $childrens = [];
            self::getAllChildren($auth, $attributes['name'], $childrens);
            return $childrens;
        } else {
            // 数据不合法
            throw new HttpException(422, $form->getFirstError());
        }
    }

    /**
     * @param $auth ManagerInterface
     * @param $name
     */
    private static function getAllChildren($auth, $name, &$childrens)
    {
        $childs = $auth->getChildren($name);
        foreach ($childs as $child) {
            ArrayHelper::push($childrens, $child);
            self::getAllChildren($auth, $child->name, $childrens);
        }
    }
}