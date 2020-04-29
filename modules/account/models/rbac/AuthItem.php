<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace account\models\rbac;

use account\models\ActiveRecord;
use yii\caching\TagDependency;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * Class AuthItem
 * @package account\models\rbac
 */
class AuthItem extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    /**
     * 验证器
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * url上加fields参数获取
     * @return array
     */
    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'data' => function ($model) {
                $data = unserialize($model->data);
                return empty($data) ? null : $data;
            },
            'created_at' => function ($model) {
                return date("Y-m-d H:i:s", $model->created_at);
            },
            'updated_at' => function ($model) {
                return date("Y-m-d H:i:s", $model->updated_at);
            },
        ]);
    }

    /**
     * 一般extraFields() 主要用于指定哪些值为对象的字段
     * url上加expand参数获取
     * @return array
     */
    public function extraFields()
    {
        return parent::extraFields();
    }

    /***************************** 触发事件 *********************************/

    /***************************** 关联数据 *********************************/

    /***************************** 增删改查 *********************************/

    /**
     * 获取列表数据（全部）
     * @param $type
     * @param $name
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function dataProvider($type, $name)
    {
        return ActiveRecord::getDb()->cache(function ($db) use ($type, $name) {
            return self::getDataProvider($type, $name);
        }, AuthItem::$dataTimeOut, new TagDependency(['tags' => [AuthItem::getAllDataTag()]]));
    }

    /**
     * 获取列表数据（全部）
     * @param $type
     * @param $name
     * @return array
     */
    private static function getDataProvider($type, $name)
    {
        $query = AuthItem::find();
        // 数据类型过滤
        $query->andFilterWhere(['type' => $type]);
        // 权限、角色名称过滤
        $query->andFilterWhere(['like', 'name', $name]);
        // 结果数据返回
        return $query->all();
    }

    /**
     * 获取列表数据（分页）
     * @param $type
     * @param $name
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function arrayDataProvider($type, $name)
    {
        return ActiveRecord::getDb()->cache(function ($db) use ($type, $name) {
            return self::getArrayDataProvider($type, $name);
        }, AuthItem::$dataTimeOut, new TagDependency(['tags' => [AuthItem::getAllDataTag()]]));
    }

    /**
     * 获取列表数据（分页）
     * @param $type
     * @param $name
     * @return ArrayDataProvider
     */
    private static function getArrayDataProvider($type, $name)
    {
        $query = AuthItem::find();
        // 数据类型过滤
        $query->andFilterWhere(['type' => $type]);
        // 权限、角色名称过滤
        $query->andFilterWhere(['like', 'name', $name, false]);
        // 结果数据返回
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count()
        ]);
        $data = $query->offset($pagination->getOffset())
            ->limit($pagination->getLimit())
            ->all();
        return new ArrayDataProvider([
            'models' => $data,
            'Pagination' => $pagination,
        ]);
    }
}
