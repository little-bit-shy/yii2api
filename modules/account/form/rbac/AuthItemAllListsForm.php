<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\rbac;

use account\models\ActiveRecord;
use account\form\Model;
use account\models\rbac\AuthItem;
use account\models\rbac\AuthItemChild;
use Yii;
use yii\caching\TagDependency;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAllListsForm
 * @package account\form\rbac
 */
class AuthItemAllListsForm extends Model
{
    public $type;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['type'], 'safe', 'on' => 'all-lists'],
            [['type'], 'default', 'value' => 2, 'on' => 'all-lists'],
            [['type'], 'in', 'range' => [1, 2], 'on' => 'all-lists'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'all-lists' => [
                'type',
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
            'type' => Yii::t('app\attribute', 'type'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 获取所有列表数据
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public static function allLists($param)
    {
        // 表单模型实例化
        $authItemIndexForm = new AuthItemAllListsForm();
        // 场景定义
        $authItemIndexForm->setScenario('all-lists');
        // 验证数据是否合法
        if ($authItemIndexForm->load([$authItemIndexForm->formName() => $param]) && $authItemIndexForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemIndexForm->getAttributes();
            $dataProvider = ActiveRecord::getDb()->cache(function ($db) use ($attributes) {
                $auth = Yii::$app->getAuthManager();
                switch ($attributes['type']) {
                    case 2:
                        $dataProvider = $auth->getPermissions();
                        break;
                    case 1:
                        $dataProvider = $auth->getRoles();
                        break;
                }
                // 结果数据返回
                return $dataProvider;
            }, AuthItem::$dataTimeOut, new TagDependency(['tags' => [AuthItem::getAllDataTag(), AuthItemChild::getAllDataTag()]]));

            return $dataProvider;
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemIndexForm->getFirstError());
        }
    }
}