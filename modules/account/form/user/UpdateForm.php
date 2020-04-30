<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2019/12/9
 * Time: 17:50
 */

namespace account\form\user;

use account\form\Model;
use account\models\User;
use app\components\AreaValidator;
use Yii;
use yii\web\HttpException;

Class UpdateForm extends Model
{
    public $account;     //昵称
    public $head;       //头像
    public $sex;        //性别 1/男 2/女
    public $phone;      //联系电话
    public $province;   //省
    public $city;       //市
    public $area;       //区
    public $address;    //联系地址
    public $qq;    //qq

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['account', 'head', 'sex', 'phone', 'province', 'city', 'area', 'address','qq'], 'safe', 'on' => 'update'],
            [['account', 'head', 'phone', 'province', 'city', 'area', 'address','qq'], 'string', 'on' => 'update'],
            [['account', 'head', 'phone', 'province', 'city', 'area', 'address','qq'], 'trim', 'on' => 'update'],
            [['province'], AreaValidator::className(), 'skipOnEmpty' => true, 'on' => 'update'],
            [['sex'], 'integer', 'on' => 'update'],
            [['sex'], 'required', 'on' => 'update'],
            [['sex'], 'in', 'range' => [1, 2], 'on' => 'update'],
            [['phone'], 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/', 'on' => 'update'],
        ];
    }

    /**
     * 使用场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'update' => ['account', 'head', 'sex', 'phone', 'province', 'city', 'area', 'address','qq'],
        ];
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'account' => Yii::t('app/attribute', 'account'),
            'head' => Yii::t('app/attribute', 'head'),
            'sex' => Yii::t('app/attribute', 'sex'),
            'phone' => Yii::t('app/attribute', 'phone'),
            'province' => Yii::t('app/attribute', 'province'),
            'city' => Yii::t('app/attribute', 'city'),
            'area' => Yii::t('app/attribute', 'area'),
            'address' => Yii::t('app/attribute', 'address'),
            'qq' => Yii::t('app/attribute', 'qq'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 修改用户信息
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function update($param)
    {
        $updateForm = new self();
        $updateForm->setScenario('update');
        if ($updateForm->load([$updateForm->formName() => $param]) && $updateForm->validate()) {
            //验证过滤后的数据
            $attributes = $updateForm->getAttributes();
            $userId = Yii::$app->getUser()->getId();
            if (User::updateUser(
                $userId,
                $attributes['account'],
                $attributes['head'],
                $attributes['sex'],
                $attributes['phone'],
                $attributes['province'],
                $attributes['city'],
                $attributes['area'],
                $attributes['address'],
                $attributes['qq']
            )) {
                throw new HttpException(200,  Yii::t('app/success','data update successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            throw new HttpException(442, $updateForm->getFirstError());
        }
    }


    /***************************** 获取数据 *********************************/


}