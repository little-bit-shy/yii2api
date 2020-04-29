<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2016/11/8
 * Time: 15:42
 * @desc 树状结构
 */

namespace app\components;

use yii\helpers\Url;

class Helper
{
    /**
     * 日期转时间戳
     * @param $date
     * @return int|null
     */
    public static function date2time($date)
    {
        if (empty($date)) {
            return null;
        }
        return strtotime($date);
    }

    /**
     * 日期
     * @param $format
     * @param $time
     * @return false|string
     */
    public static function dateFormat($format, $time)
    {
        return date($format, $time);
    }

    /**
     * 生成订单号
     * @return string
     */
    public static function orderId()
    {
        return date('YmdHis') . rand(100000, 999999);
    }

    /**
     * xml转string
     * @param $data
     * @param string $class_name
     * @param int $options
     * @param string $ns
     * @param bool $is_prefix
     * @return \SimpleXMLElement
     */
    public static function xmlToString($data, $class_name = "SimpleXMLElement", $options = 0, $ns = "", $is_prefix = false)
    {
        return simplexml_load_string($data, $class_name, $options, $ns, $is_prefix);
    }

    /**
     * 根据字符串生成临时文件
     * @param $tmpFilea 必须是静态变量
     * @param $content  内容
     * @return mixed
     */
    public static function getTmpPathByContent(&$tmpFilea, $content)
    {
        $tmpFilea = tmpfile();
        fwrite($tmpFilea, $content);
        $tempPemPath = stream_get_meta_data($tmpFilea);
        return $tempPemPath['uri'];
    }

    /**
     * 向下取整
     * @param $value
     * @return float
     */
    public static function floor($value)
    {
        return floor($value);
    }

    /**
     * 向上取整
     * @param $value
     * @return float
     */
    public static function ceil($value)
    {
        return ceil($value);
    }

    /**
     * 保留2位小数，不四舍五入
     * @param $value
     * @return float|int
     */
    public static function formatNumberTwo($value)
    {
        return Helper::floor($value * 100) / 100;
    }

    /**
     * 获取请求地址
     * @param $url
     * @return string
     */
    public static function urlTo($url)
    {
        if (self::isSsl() == true) {
            $result = Url::to($url, 'https');
        } else {
            $result = Url::to($url, true);
        }
        return $result;
    }

    /**
     * 判断是否SSL协议
     * @return bool
     */
    public static function isSsl()
    {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return true;
        } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return true;
        }
        return false;
    }

}
