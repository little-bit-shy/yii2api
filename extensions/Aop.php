<?php
namespace app\extensions;

use Yii;
use yii\base\BaseObject;

require_once __DIR__ . '/aop/AopClient.php';
require_once __DIR__ . '/aop/request/AlipayTradePagePayRequest.php';

class Aop extends BaseObject
{
    public $gatewayUrl;
    public $appId;
    public $rsaPrivateKey;
    public $alipayrsaPublicKey;
    public $alipayPublicKey;
    public $apiVersion;
    public $signType;
    public $postCharset;
    public $format;

    /**
     * Aop constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (empty($config)) {
            $params = Yii::$app->params;
            $config = $params['aop'];
        }
        parent::__construct($config);
    }


    /**
     * 跳转支付
     * @param String $out_trade_no 商户订单号,64个字符以内、可包含字母、数字、下划线；需保证在商户端不重复
     * @param Double $total_amount 订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]。
     * @param String $subject 订单标题
     * @param String $body 订单描述
     * @param String $passback_params 公用回传参数，如果请求时传递了该参数，则返回给商户时会回传该参数。支付宝只会在同步返回（包括跳转回商户网站）和异步通知时将该参数原样返回。本参数必须进行UrlEncode之后才可以发送给支付宝。
     * @param String $notifyUrl 异步通知地址
     * @param String $returnUrl 同步通知地址
     * @return String
     * @throws \Exception
     */
    public function order($out_trade_no, $total_amount, $subject, $body, $passback_params, $notifyUrl, $returnUrl)
    {
        $aop = new \AopClient ();

        $aop->gatewayUrl = $this->gatewayUrl;
        $aop->appId = $this->appId;
        $aop->rsaPrivateKey = $this->rsaPrivateKey;
        $aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
        $aop->apiVersion = $this->apiVersion;
        $aop->signType = $this->signType;
        $aop->postCharset = $this->postCharset;
        $aop->format = $this->format;

        $request = new \AlipayTradePagePayRequest ();
        $request->setNotifyUrl($notifyUrl);
        $request->setReturnUrl($returnUrl);
        $request->setBizContent("{" .
            "    \"out_trade_no\":\"{$out_trade_no}\"," .
            "    \"product_code\":\"FAST_INSTANT_TRADE_PAY\"," .
            "    \"total_amount\":{$total_amount}," .
            "    \"subject\":\"{$subject}\"," .
            "    \"body\":\"{$body}\"," .
            "    \"passback_params\":\"{$passback_params}\"" .
            "  }");
        $result = $aop->pageExecute($request);
        return $result;
    }

    /**
     * 数据验签
     * @param $params
     * @return bool
     */
    public function rsaCheckV1($params)
    {
        $aop = new \AopClient ();
        $aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
        return $aop->rsaCheckV1($params, $aop->alipayrsaPublicKey, $this->signType);
    }
}

