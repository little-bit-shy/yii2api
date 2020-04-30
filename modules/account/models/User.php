<?php

namespace account\models;

use Yii;

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
     * 修改用户
     * @param $userId
     * @param $account
     * @param $head
     * @param $sex
     * @param $phone
     * @param $province
     * @param $city
     * @param $area
     * @param $address
     * @param $qq
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function updateUser($userId, $account, $head, $sex, $phone, $province, $city, $area, $address,$qq)
    {
        $user = User::findOne([
            'tenant_id' => $userId
        ]);
        $user->load([$user->formName() => [
            'account' => $account,
            'head' => $head,
            'sex' => $sex,
            'phone' => $phone,
            'province' => $province,
            'city' => $city,
            'area' => $area,
            'address' => $address,
            'qq' => $qq,
        ]]);
        return $user->save();
    }

    /**
     * 通过用户id重置用户密码
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

    /**
     * 通过手机重置用户密码
     * @param $mobile
     * @param $password_hash
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function ResetPswMobile($mobile, $password_hash)
    {
        $time = time();
        $user = User::findOne([
            'mobile' => $mobile
        ]);
        $user->load([$user->formName() => [
            'password' => $password_hash,
            'updated_at' => $time,
        ]]);
        return $user->save();
    }
}
