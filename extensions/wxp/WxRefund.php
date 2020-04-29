<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2020/1/7
 * Time: 12:29
 */

Class WxRefund extends WxPayRefund
{
    /**
     * 设置回调
     * @param string $value
     **/
    public function SetNotifyUrl($value)
    {
        $this->values['notify_url'] = $value;
    }

    /**
     * 获取回调
     * @return 值
     **/
    public function GetNotifyUrl()
    {
        return $this->values['notify_url'];
    }

}