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

            -1100009 => "姓名为空",
            -1100010 => "姓名格式错误",
            -1100011 => "所属医院为空",
            -1100012 => "所属医院格式错误",
            -1100013 => "所属科室为空",
            -1100014 => "所属科室格式错误",
            -1100015 => "职称为空",
            -1100016 => "职称格式错误",
            -1100017 => "手机号码为空",
            -1100018 => "手机号码格式错误",
            -1100019 => "所属销售名称格式错误",
            -1100020 => "所属销售手机号码格式错误",
            -1100021 => "医生ID为空",
            -1100022 => "医生ID格式错误",
            -1100023 => "一分钟内请勿重复发送验证码",
            -1100024 => "验证码类型为空",
            -1100025 => "验证码类型格式错误",
            -1100026 => "验证码为空",
            -1100027 => "验证码格式错误",

            -2100001 => "医生不存在",
            -2100002 => "删除医生失败",
            -2100003 => "绑定失败",
            -2100004 => "短信发送失败",
            -2100005 => "验证码错误",
            -2100006 => "验证码无效",

            
            -9999998 => "系统错误，请重新操作",
            -9999999 => "服务器系统错误",
        ];
        if (array_has($messageArray, $code)) {
            return $messageArray[$code];
        }
        return "服务器系统错误";
    }
}