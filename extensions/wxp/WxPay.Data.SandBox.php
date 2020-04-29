<?php

/**
 * Created by PhpStorm.
 * User: 123
 * Date: 2019/12/5
 * Time: 12:43
 */
Class WxPayDataSandBox extends WxPayDataBase
{
    /**
     * 生成签名
     * @param $params
     * @param WxPayConfigInterface $config
     * @return string
     * @throws WxPayException
     */
    public function MakeSignParms($params, $config)
    {
        //签名步骤一：按字典序排序数组参数
        ksort($params);
        $string = $this->UrlToParams($params);  //参数进行拼接key=value&k=v
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $config->GetKey();
        //签名步骤三：MD5加密或者HMAC-SHA256
        if ($config->GetSignType() == "MD5") {
            $string = md5($string);
        } else if ($config->GetSignType() == "HMAC-SHA256") {
            $string = hash_hmac("sha256", $string, $config->GetKey());
        } else {
            throw new WxPayException("签名类型不支持！");
        }
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public function UrlToParams($params)
    {
        $buff = "";
        if (!empty($params)) {
            foreach ($params as $k => $v) {
                if ($k != "sign" && $v != "" && !is_array($v)) {
                    $buff .= $k . "=" . $v . "&";
                }
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 输出xml字符
     * @param $arr
     * @return string
     * @throws WxPayException
     */
    public function ArrayToXml($arr)
    {
        if(!is_array($arr) || count($arr) == 0) return '';

        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".trim($val)."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 输出root字符
     * @param $arr
     * @return string
     * @throws WxPayException
     */
    public function ArrayToRoot($arr)
    {
        if(!is_array($arr) || count($arr) == 0) return '';

        $xml = "<root>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".trim($val)."]]></".$key.">";
            }
        }
        $xml.="</root>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param $xml
     * @return array|bool
     * @throws WxPayException
     */
    public static function XmlToArray($xml)
    {
        $obj = new self();
        $obj->FromXml($xml);
        //失败则直接返回失败
        if ($obj->values['return_code'] != 'SUCCESS') {
            foreach ($obj->values as $key => $value) {
                #除了return_code和return_msg之外其他的参数存在，则报错
                if ($key != "return_code" && $key != "return_msg") {
                    throw new WxPayException("输入数据存在异常！");
                    return false;
                }
            }
            return $obj->GetValues();
        }
        return $obj->GetValues();
    }

}