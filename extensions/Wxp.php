<?php

namespace app\extensions;

use app\components\ArrayHelper;
use app\components\Helper;
use app\components\StringHelper;
use Yii;
use yii\base\BaseObject;
use yii\helpers\BaseStringHelper;
use yii\helpers\Json;
use yii\web\HttpException;

require_once __DIR__ . "/wxp/lib/WxPay.Api.php";
require_once __DIR__ . "/wxp/lib/WxPay.Data.php";
require_once __DIR__ . "/wxp/WxPay.Config.php";
require_once __DIR__ . "/wxp/WxRefund.php";
require_once __DIR__ . "/wxp/lib/WxPay.Notify.php";


class Wxp extends BaseObject
{
    public $appId;
    public $merchantId;
    public $notifyUrl;
    public $secret;
    public $signType;
    public $proxy;
    public $proxyHost;
    public $proxyPort;
    public $reportLevenl;
    public $key;
    public $appSecret;
    public $sslCertPath;
    public $sslKeyPath;

    /**
     * Aop constructor.
     * @param array $config
     */
    public function __construct($type = 'wxp')
    {
        $params = Yii::$app->params;
        if (StringHelper::strpos($type, '.')) {
            $exp = StringHelper::explode($type, '.');
            $count = count($exp);
            for ($i = 0; $i < $count; $i++) {
                $temp = $params;
                $params = $temp[$exp[$i]];
            }
            $config = $params;
        } else {
            $config = $params[$type];
        }
        parent::__construct($config);
    }

    /**
     * 微信扫码支付
     * @param String (128) $body 商品描述 例：腾讯充值中心-QQ会员充值
     * @param String (127) $attach 附加数据，在查询API和支付通知中原样返回，可作为自定义参数使用
     * @param String (32) $outTradeNo 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|* 且在同一个商户号下唯一
     * @param Int $totalFee 订单总金额，单位为分 沙箱环境金额至少为2元起
     * @param String (256) $notifyUrl 异步接收微信支付结果通知的回调地址，通知url必须为外网可访问的url，不能携带参数
     * @param String (32) $productId trade_type=NATIVE时，此参数必传。此参数为二维码中包含的商品ID，商户自行定义
     * @return mixed 成功时返回，其他抛异常
     * @throws HttpException
     * @throws \WxPayException
     */
    public function order($body, $attach, $outTradeNo, $totalFee, $notifyUrl, $productId)
    {
        /** 获取配置文件信息 **/
        $config = new \WxPayConfig();
        $config->appId = $this->appId;
        $config->merchantId = $this->merchantId;
        $config->signType = $this->signType;
        $config->key = $this->key;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($body);
        $input->SetAttach($attach);
        $input->SetOut_trade_no($outTradeNo);
        $input->SetTotal_fee($totalFee);
        $input->SetNotify_url($notifyUrl);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($productId);
        try {
            //进行扫码支付
            $result = \WxPayApi::unifiedOrder($config, $input);
        } catch (\Exception $e) {
            throw new HttpException('500', Yii::t('app/error', 'the wechat payment call failed'));
        }
        if ($result['return_code'] != 'SUCCESS') {
            throw new HttpException('500', Yii::t('app/error', 'the wechat payment call failed'));
        }
        return $result;
    }


    /**
     * 微信退款
     * @param $outTradeNo   订单号
     * @param $outRefundNo  退款单号
     * @param $totalFee     订单金额 （分为单位）
     * @param $refundFee    退款金额  （分为单位）
     * @param $notifyUrl    回调地址
     * @param $wxappId    微信配置id
     * @param bool $merchantId 商户id
     * @param bool $apiKey 商户密钥
     * @param bool $sslCert 商户证书
     * @param bool $sslKey 商户证书密钥
     * @return \成功时返回，其他抛异常
     * @throws HttpException
     */
    public function refund($outTradeNo, $outRefundNo, $totalFee, $refundFee, $notifyUrl = false, $wxappId = false, $merchantId = false, $apiKey = false, $sslCert = false, $sslKey = false)
    {
        /** 获取配置文件信息 **/
        $config = new \WxPayConfig();
        $config->appId = $this->appId;
        //默认获取配置的商户号
        if ($merchantId) {
            $config->merchantId = $merchantId;
        } else {
            $config->merchantId = $this->merchantId;
        }
        $config->signType = $this->signType;
        //默认使用配置的支付密钥
        if ($apiKey) {
            $config->key = $apiKey;
        } else {
            $config->key = $this->key;
        }
        //将证书内容生成临时文件
        static $cert = null;
        //默认使用配置的证书
        if ($sslCert) {
            $certPath = Helper::getTmpPathByContent($cert, $sslCert);
        } else {
            $certPath = Helper::getTmpPathByContent($cert, $this->sslCertPath);
        }
        static $key = null;
        //默认使用配置的证书密钥
        if ($sslKey) {
            $keyPath = Helper::getTmpPathByContent($key, $sslKey);
        } else {
            $keyPath = Helper::getTmpPathByContent($key, $this->sslKeyPath);
        }
        $config->sslCertPath = $certPath;
        $config->sslKeyPath = $keyPath;
        $input = new \WxRefund();
        //生成退款单
        $input->SetOut_trade_no($outTradeNo);
        $input->SetTotal_fee($totalFee);
        $input->SetRefund_fee($refundFee);
        $input->SetOut_refund_no($outRefundNo);
        $input->SetOp_user_id($config->GetMerchantId());
        if ($notifyUrl) {
            $input->SetNotifyUrl($notifyUrl);
        }
        try {
            $result = \WxPayApi::refund($config, $input);
        } catch (\Exception $e) {
            throw new HttpException('500', Yii::t('app/error', 'wechat refund failed'));
        }
        if ($result['return_code'] != 'SUCCESS') {
            throw new HttpException('500', Yii::t('app/error', 'wechat refund failed'));
        }
        return $result;
    }

    /**
     * 微信密码支付
     * @param String (128) $body 商品描述 例：腾讯充值中心-QQ会员充值
     * @param String (127) $attach 附加数据，在查询API和支付通知中原样返回，可作为自定义参数使用
     * @param String (32) $outTradeNo 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|* 且在同一个商户号下唯一
     * @param Int $totalFee 订单总金额，单位为分 沙箱环境金额至少为2元起
     * @param String (256) $notifyUrl 异步接收微信支付结果通知的回调地址，通知url必须为外网可访问的url，不能携带参数
     * @param String (32) $productId trade_type=NATIVE时，此参数必传。此参数为二维码中包含的商品ID，商户自行定义
     * @param String $merchantId 商户号
     * @param String $apiKey 商户密钥
     * @return \成功时返回，其他抛异常
     * @throws HttpException
     */
    public function unifiedOrder($body, $attach, $outTradeNo, $totalFee, $notifyUrl, $openId, $productId, $merchantId = false, $apiKey = false)
    {
        /** 获取配置文件信息 **/
        $config = new \WxPayConfig();
        $config->appId = $this->appId;
        //默认使用配置的商户
        if ($merchantId) {
            $config->merchantId = $merchantId;
        } else {
            $config->merchantId = $this->merchantId;
        }
        //默认使用配置的支付密钥
        if ($apiKey) {
            $key = $apiKey;
        } else {
            $key = $this->key;
        }
        $config->key = $key;
        $config->signType = $this->signType;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($body);
        $input->SetAttach($attach);
        $input->SetGoods_tag('goods');
        $input->SetOut_trade_no($outTradeNo);
        $input->SetTotal_fee($totalFee);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url($notifyUrl);
        $input->SetTrade_type("JSAPI");
        $input->SetProduct_id($productId);
        $input->SetOpenid($openId);
        try {
            //进行密码支付
            $result = \WxPayApi::unifiedOrder($config, $input);
            if ($result['return_code'] != 'SUCCESS') {
                throw new HttpException('500', Yii::t('app/error', $result['return_msg']));
            }
            if ($result['result_code'] != 'SUCCESS') {
                throw new HttpException('500', Yii::t('app/error', $result['err_code_des']));
            }
        } catch (\Exception $e) {
            throw new HttpException('500', Yii::t('app/error', $e->getMessage()));
        }
        $options = $this->createMchPay($result['prepay_id'], $config);
        return $options;
    }

    /**
     * 签名验证
     * @param $param
     * @return string
     * @throws \WxPayException
     */
    public function checkSign($param)
    {
        $config = new \WxPayConfig();
        $config->appId = $this->appId;
        $config->merchantId = $this->merchantId;
        $config->signType = $this->signType;
        $config->key = $this->key;
        $wxpayDataSandBox = new \WxPayDataSandBox();
        $paramSign = $param['sign'];
        unset($param['sign']);
        $sign = $wxpayDataSandBox->MakeSignParms($param, $config);
        return ($paramSign == $sign);
    }

    /**
     * 返回通知
     * @throws \WxPayException
     */
    public static function renewal($code)
    {
        $notify = new \WxPayNotify();
        $notify->SetReturn_code($code);
        $notify->SetReturn_msg("OK");
        return $notify->ToXml();
    }

    /**
     * 此方法验证小程序配置信息是否正确
     * @param $mchid
     * @param $apikey
     * @param $apiclientCert
     * @param $apiclientKey
     * @return bool
     */
    public function checkWxapp($mchid, $apikey, $apiclientCert, $apiclientKey)
    {
        /** 获取配置文件信息 **/
        $config = new \WxPayConfig();
        $config->appId = $this->appId;
        $config->signType = $this->signType;
        $config->key = $apikey;
        //将证书内容生成临时文件
        static $cert = null;
        $certPath = Helper::getTmpPathByContent($cert, $apiclientCert);
        static $key = null;
        $keyPath = Helper::getTmpPathByContent($key, $apiclientKey);
        $config->sslCertPath = $certPath;
        $config->sslKeyPath = $keyPath;
        $config->merchantId = $mchid;
        $input = new \WxRefund();
        //生成退款单
        $order = Helper::orderId();
        $input->SetOut_trade_no($order);
        $input->SetTotal_fee(200);
        $input->SetRefund_fee(200);
        $input->SetOut_refund_no($order);
        $input->SetOp_user_id($config->GetMerchantId());
        try {
            $result = \WxPayApiSandBox::refund($config, $input);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /*
     * 创建JSAPI支付参数包
     * @param string $prepay_id
     * @return array
     */
    public function createMchPay($prepay_id, $config)
    {
        $option = array();
        $option["appId"] = $this->appId;
        $option["timeStamp"] = (string)time();
        $option["nonceStr"] = \WxPayApi::getNonceStr();
        $option["package"] = "prepay_id={$prepay_id}";
        $option["signType"] = "MD5";
        $wxpayDataSandBox = new \WxPayDataSandBox();
        $option["paySign"] = $wxpayDataSandBox->MakeSignParms($option, $config);
        return $option;
    }
}

