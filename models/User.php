<?php

namespace app\models;

use app\controllers\behaviors\QueryParamAuth;
use app\models\redis\AccessToken;
use app\models\redis\RateLimit;
use Yii;
use yii\caching\TagDependency;
use yii\filters\RateLimitInterface;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

class User extends ActiveRecord implements IdentityInterface, RateLimitInterface
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
            [['tenant_id', 'account', 'mobile', 'openid', 'password', 'create_at', 'update_at', 'is_able'], 'safe'],
        ];
    }

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * url上加fields参数获取
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password']);
        return $fields;
    }

    /***************************** 登陆相关 *********************************/

    public static function findIdentity($id)
    {
        return User::findOne([
            "tenant_id" => $id
        ]);
    }

    /**
     * 获取用户信息
     * @param mixed $token
     * @param null $type
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // 获取对应 AccessToken 数据
        $accessToken = AccessToken::findAccessToken($token);
        // 数据不存在
        if (empty($accessToken)) {
            throw new UnauthorizedHttpException(Yii::t('app/error', 'access token no exist'));
        }
        $tenant_id = $accessToken['tenant_id'];
        // 获取数据库对应数据
        $query = User::find();
        // 缓存依赖
        $query->cache(true, new TagDependency(['tags' => [User::getUserDataTag($tenant_id)]]));
        $query->andWhere([
            "tenant_id" => $tenant_id
        ]);
        $user = $query->one();
        return $user;
    }

    public function getId()
    {
        return $this->tenant_id;
    }

    public function getMobile()
    {
        return $this->mobile;
    }


    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
    }

    /**
     * 获取 AcceessToken
     * @return array|mixed
     */
    public static function getAccessToken()
    {
        return Yii::$app->getRequest()->get((new QueryParamAuth())->tokenParam);
    }

    /**
     * 密码验证
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * 通过用户手机号获取用户详细信息
     * @param $mobile
     * @return null|static
     */
    public static function findIdentityByMobile($mobile)
    {
        return User::findOne(['mobile' => $mobile]);
    }

    /**
     * 通过用户ID获取用户详细信息
     * @param $id
     * @return null|static
     */
    public static function findIdentityById($id)
    {
        return User::findOne(['tenant_id' => $id]);
    }

    /**
     * 登陆操作
     * @param $mobile
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function login($mobile)
    {
        $time = time();
        $user = self::findIdentityByMobile($mobile);
        // 更新用户信息
        $user->load([$user->formName() => [
            'update_at' => $time
        ]]);
        $user->save();
        // access_token 创建
        $accessToken = AccessToken::createAccessToken($user->tenant_id);

        // access_token持久化日志记录
        $access = new Access();
        $access->load([$access->formName() => [
            'access_token' => $accessToken['access_token'],
            'tenant_id' => $accessToken['tenant_id'],
            'remove_at' => $accessToken['remove_at'],
            'create_at' => $time,
            'update_at' => $time,
        ]]);
        $access->save();
        return $accessToken;
    }

    /**
     * 退出登录
     * @return false|int
     */
    public static function logout(){
        return AccessToken::removeAccessToken(self::getAccessToken());
    }

    /***************************** 请求频率 *********************************/

    /**
     * getRateLimit(): 返回允许的请求的最大数目及时间，例如，[100, 600] 表示在600秒内最多100次的API调用。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     */
    public function getRateLimit($request, $action)
    {
        return [RateLimit::$rateLimit, RateLimit::$second];// $rateLimit requests per second
    }

    /**
     * loadAllowance(): 返回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     */
    public function loadAllowance($request, $action)
    {
        $id = \Yii::$app->getUser()->getId();//获取当前登录用户id
        $uniqueId = $action->getUniqueId();
        $rateLimit = RateLimit::one($id, $uniqueId);//获取当前登录用户Api请求频率相关数据
        if ($rateLimit == null) {
            // 当redis不存在数据时
            return [RateLimit::$rateLimit, time()];
        } else {
            return [$rateLimit['allowance'], $rateLimit['allowance_updated_at']];
        }
    }

    /**
     * saveAllowance(): 保存允许剩余的请求数和当前的UNIX时间戳。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @param int $allowance
     * @param int $timestamp
     * @throws \yii\base\InvalidConfigException
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $id = Yii::$app->getUser()->getId();
        $uniqueId = $action->getUniqueId();

        //更新当前登录用户Api请求频率相关数据
        RateLimit::saveAllowance($id, $uniqueId, $allowance, $timestamp);
    }
}
