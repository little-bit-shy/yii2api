<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\form\rbac;

use account\form\Model;
use account\models\rbac\AuthItem;
use app\components\LikeValidator;
use app\components\StringHelper;
use Yii;
use yii\db\Query;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemIndexForm
 * @package account\form\rbac
 */
class AuthItemIndexForm extends Model
{
    public $type;
    public $name;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'safe', 'on' => 'index'],
            [['name'], 'string', 'on' => 'index'],
            [['name'], LikeValidator::className(), 'skipOnEmpty' => true, 'on' => 'index'],
            [['type'], 'default', 'value' => 2, 'on' => 'index'],
            [['type'], 'in', 'range' => [1, 2], 'on' => 'index'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'index' => [
                'type',
                'name'
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
     * 获取列表数据
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public static function lists($param)
    {
        // 表单模型实例化
        $authItemIndexForm = new AuthItemIndexForm();
        // 场景定义
        $authItemIndexForm->setScenario('index');
        // 验证数据是否合法
        if ($authItemIndexForm->load([$authItemIndexForm->formName() => $param]) && $authItemIndexForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemIndexForm->getAttributes();
            // 获取数据
            $dataProvider = AuthItem::arrayDataProvider($attributes['type'], $attributes['name']);
            return $dataProvider;
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemIndexForm->getFirstError());
        }
    }
}