<?php

namespace App\Helper;


class MessagesHelper
{
    public static function get($code)
    {
        $messageArray = [
            1 => "success",
            -1100001 => "头部信息缺失",
            -1100002 => "无效的请求 ",
            -1100003 => "无效的 grant type",
            -1100004 => "client 无效",
            -1100005 => "无效的token",
            -1100006 => "手机号格式错误",
            -1100007 => "类型格式错误",
            -1100008 => "密码格式错误",
            -1100009 => "大棚ID格式错误",
            -1100010 => "拍摄类型格式错误",
            -1100011 => "无效的拍摄类型",
            -1100012 => "拍摄部位为空",
            -1100013 => "图片为空",
            -1100014 => "版本格式错误",
            -1100015 => "一分钟内请勿重复发送验证码",
            
            -9999998 => "系统错误，请重新操作",
            -9999999 => "服务器系统错误",
        ];
        if (array_has($messageArray, $code)) {
            return $messageArray[$code];
        }
        return "服务器系统错误";
    }
}