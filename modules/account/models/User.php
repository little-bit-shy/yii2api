<?php

namespace account\models;

use app\models\redis\AccessToken;
use app\controllers\behaviors\QueryParamAuth;
use Yii;
use yii\caching\TagDependency;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;

/**
 * Class User
 * @package account\models
 */
class User extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tenant}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['tenant_id', 'account', 'mobile', 'password', 'create_at', 'update_at', 'is_able',
                'head', 'sex', 'province', 'city', 'area', 'address', 'phone', 'qq'
            ], 'safe'],
        ];
    }

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * url上加fields参数获取
     * @return array
     */
    public function fields()
    {
        return parent::fields();
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
     * 获取列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function lists()
    {
        $user = ActiveRecord::getDb()->cache(function ($db) {
            return self::getLists();
        }, User::$dataTimeOut, new TagDependency(['tags' => [User::getAllDataTag()]]));
        return $user;
    }

    /**
     * 获取用户列表数据
     * @return ArrayDataProvider
     */
    private static function getLists()
    {
        $query = User::find();
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

    /**
     * 添加用户
     * @param $account
     * @param $password
     * @param $mobile
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function addUser($account, $password, $mobile)
    {
        $time = time();
        $user = new User();
        $user->load([$user->formName() => [
            'account' => $account,
            'password' => $password,
            'mobile' => $mobile,
            'created_at' => $time,
            'updated_at' => $time,
        ]]);
        return $user->save();
    }

    /**
     * 重置用户密码
     * @param $id
     * @param $password_hash
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function ResetPsw($id, $password_hash)
    {
        $time = time();
        $user = User::findOne([
            'tenant_id' => $id
        ]);
        $user->load([$user->formName() => [
            'password' => $password_hash,
            'updated_at' => $time,
        ]]);
        return $user->save();
    }
}
