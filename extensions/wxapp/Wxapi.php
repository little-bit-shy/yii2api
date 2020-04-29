<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2019/12/23
 * Time: 15:24
 */

namespace app\extensions\wxapp;

use yii\helpers\Json;
use Yii;

/**
 * 微信接口基类
 * Class Api
 */
class Wxapi
{

    /**
     * 请求接口
     * @param $url
     * @param array $param
     * @param string $method
     * @param bool $ssl
     * @return bool|string
     */
    protected static function run($url, $param = [], $method = 'GET', $ssl = false, $path = false)
    {
        switch ($method) {
            case 'POST':
                $param = Json::encode($param);
                break;
            case 'GET':
                $uri = '?';
                foreach ($param as $key => $value) {
                    $uri .= $key . '=' . $value . '&';
                }
                $url = substr($url . $uri, 0, -1);
                break;
            default:
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        switch ($method) {
            case 'POST':
                $headers[] = 'Content_Length:' . strlen($param);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
                break;
            default:
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


}
