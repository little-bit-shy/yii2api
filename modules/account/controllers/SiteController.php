<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: 用户登录相关操作控制器
 */

namespace account\controllers;

use account\form\user\ForgetForm;
use account\form\user\RegisteredForm;
use account\form\user\ResetPswForm;
use account\form\user\UpdateForm;
use Yii;
use account\form\rbac\AllPermissionsForm;
use account\form\sms\SmsCodeForm;
use account\form\user\LoginForm;
use account\form\user\LogoutForm;
use account\form\user\TenantInfoForm;
use app\controllers\behaviors\QueryParamAuth;
use yii\captcha\CaptchaAction;

class SiteController extends Controller
{

    /**
     * 定义相关行为
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'optional' => ['captcha', 'login', 'forget', 'sms-code', 'registered']
        ];

        return $behaviors;
    }

    /**
     * 访问方法设置
     * @apiDefine account 个人中心
     * @return array
     */
    protected function verbs()
    {
        return [
            'captcha' => ['GET', 'POST'],
            'registered' => ['POST'],
            'login' => ['POST'],
            'forget' => ['POST'],
            'logout' => ['GET', 'POST'],
            'sms-code' => ['POST'],
            'tenant-info' => ['GET', 'POST'],
            'all-permissions' => ['GET', 'POST'],
            'update' => ['POST'],
            'reset-psw' => ['POST'],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => CaptchaAction::className(),
                'maxLength' => 4,
                'minLength' => 4,
                'padding' => 5,
                'height' => 39,
                'width' => 100,
                'offset' => 3,
            ],
        ];
    }

    /**
     * @api {POST} /account/default/login 用户登录
     * @apiVersion 1.0.0
     * @apiName default/login
     * @apiGroup account
     * @apiSampleRequest off
     *
     * @apiParam (params) {String} mobile  手机号码
     * @apiParam (params) {String} [password]  密码
     * @apiParam (params) {String} [captcha]  手机验证码
     *
     * @apiSuccessExample Success-Response:
     * {
     * "success": true,
     * "data": {
     * // 登录口令
     * "access_token": "d31f303dfddd3cd725cb04101b4d5e02",
     * // 用户id
     * "tenant_id": 1,
     * // 口令过期时间
     * "remove_at": 1568872454
     * }
     * }
     *
     * @return \account\models\User
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionLogin()
    {
        return LoginForm::login($this->getParams());
    }

    /**
     * @api {POST} /account/default/forget 密码重置（忘记密码）
     * @apiVersion 1.0.0
     * @apiName default/forget
     * @apiGroup account
     * @apiSampleRequest off
     *
     * @apiParam (params) {String} mobile  手机号码
     * @apiParam (params) {String} password  新密码
     * @apiParam (params) {String} captcha  手机验证码
     *
     * @apiSuccessExample Success-Response:
     * {
     * "success": true,
     * "data": {
     * "name": "OK",
     * "message": "数据修改成功",
     * "code": 0,
     * "status": 200
     * }
     * }
     *
     * @return \account\models\User
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionForget()
    {
        return ForgetForm::forget($this->getParams());
    }

    /**
     * @api {POST} /account/default/registered 用户注册
     * @apiVersion 1.0.0
     * @apiName default/registered
     * @apiGroup account
     * @apiSampleRequest off
     *
     * @apiParam (params) {String} mobile  手机号码
     * @apiParam (params) {String} password  密码
     * @apiParam (params) {String} captcha  手机验证码
     *
     * @apiSuccessExample Success-Response:
     * {
     * "success": true,
     * "data": {
     * "name": "OK",
     * "message": "用户注册成功",
     * "code": 0,
     * "status": 200
     * }
     * }
     *
     * @return mixed
     * @throws \yii\web\HttpException
     */
    public function actionRegistered()
    {
        return RegisteredForm::registered($this->getParams());
    }

    /**
     * @api {POST} /account/default/logout 用户登出
     * @apiVersion 1.0.0
     * @apiName default/logout
     * @apiGroup account
     * @apiSampleRequest off
     *
     * @apiUse publicParam
     *
     * @apiSuccessExample Success-Response:
     * {
     * "success": true,
     * "data": {
     * "name": "OK",
     * "message": "登出成功",
     * "code": 0,
     * "status": 200
     * }
     * }
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\HttpException
     */
    public function actionLogout()
    {
        return LogoutForm::logout($this->getQueryParams());
    }

    /**
     * @api {POST} /account/default/sms-code 发送手机验证码
     * @apiVersion 1.0.0
     * @apiName default/sms-code
     * @apiGroup account
     * @apiSampleRequest off
     *
     * @apiParam (params) {String} mobile  手机号码
     *
     * @apiSuccessExample Success-Response:
     * {
     * "success": true,
     * "data": {
     * "name": "OK",
     * "message": "验证码发送成功",
     * "code": 0,
     * "status": 200
     * }
     * }
     *
     * @throws \yii\web\HttpException
     */
    public function actionSmsCode()
    {
        return SmsCodeForm::smsCode($this->getParams());
    }

    /**
     * @api {GET} /account/default/tenant-info 获取用户信息
     * @apiVersion 1.0.0
     * @apiName default/tenant-info
     * @apiGroup account
     * @apiSampleRequest off
     *
     * @apiUse publicParam
     *
     * @apiSuccess {Int} tenant_id 用户id
     * @apiSuccess {String} account 名称
     * @apiSuccess {String} mobile 手机号
     * @apiSuccess {Date} create_at 数据创建时间
     * @apiSuccess {Date} update_at 数据修改时间
     * @apiSuccess {Int} is_able 启用状态 0/冻结 1/未冻结
     * @apiSuccess {String} head 头像
     * @apiSuccess {Int} sex 性别 1/男 2/女
     * @apiSuccess {String} province 省
     * @apiSuccess {String} city 市
     * @apiSuccess {String} area 区
     * @apiSuccess {String} address 联系详细地址
     * @apiSuccess {String} phone 联系电话
     * @apiSuccess {String} qq    qq号
     * @apiSuccess {Object} tenantWx    用户微信信息
     * @apiSuccess {Int} tenantWx.tenant_id    用户id
     * @apiSuccess {Int} tenantWx.openid    用户openid
     * @apiSuccess {Int} tenantWx.source    来源 1/校区端 2/学生端
     *
     *
     * @apiSuccessExample Success-Response:
     * {
     * "success": true,
     * "data": {
     * "tenant_id": 1,
     * "account": "gwm",
     * "mobile": "15918793994",
     * "create_at": "2019-09-06 09:22:29",
     * "update_at": "2019-09-18 08:45:07",
     * "is_able": 1,
     * "head": "",
     * "sex": 1,
     * "province": "广东省",
     * "city": "广州市",
     * "area": "天河区",
     * "address": "你你你你你您您",
     * "phone": "15012554444",
     * "qq": null,
     * "tenantWx": {
     * "tenant_id": 2006,
     * "openid": "oghwh5bhFPd3K6gFkLqZuoHbLcqo",
     * "source": 2
     * }
     * }
     * }
     *
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionTenantInfo()
    {
        return TenantInfoForm::tenantInfo($this->getParams());
    }

    /**
     * /**
     * @api {POST} /account/default/update 修改用户信息
     * @apiVersion 1.0.0
     * @apiName default/update
     * @apiGroup account
     * @apiSampleRequest off
     *
     * @apiParam (params) {String} [phone]  联系电话
     * @apiParam (params) {String} [account]  昵称
     * @apiParam (params) {String} [province]  省
     * @apiParam (params) {String} [city]  市
     * @apiParam (params) {String} [area]  区
     * @apiParam (params) {String} [address]  详细联系地址
     * @apiParam (params) {Int} sex  性别 1/男 2/女
     * @apiParam (params) {String} [head]  头像
     * @apiParam (params) {String} [qq]  qq
     *
     * @apiSuccessExample Success-Response:
     * {
     * "success": true,
     * "data": {
     * "name": "OK",
     * "message": "数据修改成功",
     * "code": 0,
     * "status": 200
     * }
     * }
     *
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionUpdate()
    {
        return UpdateForm::update($this->getParams());
    }

    /**
     * 获取当前用户所有的权限
     * @return mixed
     * @throws \Throwable
     */
    public function actionAllPermissions()
    {
        return AllPermissionsForm::allPermissions($this->getParams());
    }

    /**
     * 重置当前用户密码
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionResetPsw()
    {
        return ResetPswForm::resetPsw($this->getParams());
    }
}
