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
use yii\data\ArrayDataProvider;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemIndexForm
 * @package account\form\rbac
 */
class AuthItemIndexForm extends Model
{
    public $type;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['type'], 'safe', 'on' => 'index'],
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
            $auth = Yii::$app->getAuthManager();
            switch ($attributes['type']) {
                case 1:
                    $models = $auth->getRoles();
                    break;
                case 2:
                    $models = $auth->getPermissions();
                    break;
            }
            return new ArrayDataProvider([
                'pagination' => false,
                'models' => $models,
            ]);
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemIndexForm->getFirstError());
        }
    }
}