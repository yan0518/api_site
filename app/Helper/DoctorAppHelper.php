<?php

namespace App\Helper;

use App\Exceptions\UnauthenticatedException;
use Illuminate\Support\Facades\Cache;
use Request;

class DoctorAppHelper
{
    public static function app_version()
    {
        if (isset(Request::header()['version']))
            return Request::header()['version'][0];

        return false;
    }

    public static function app_id()
    {
        if (isset(Request::header()['appid']))
            return Request::header()['appid'][0];
        return false;
    }

    //登入情况使用
    public static function user_id()
    {
        $user = Request::user();
        if ($user) {
            return $user->_id;
        }
        throw new UnauthenticatedException();
    }

    public static function getIP()
    {
        return Request::ip();
    }

    public static function getFullUrl(){
        return Request::fullUrl();
    }

    public static function getUri(){
        return Request::getPathInfo();
    }

    public static function isAppVersion($value) {
        $value = trim($value);
        if (!$value) {
            return false;
        }
        return preg_match('/^(((\d{1,4})\.){2}\d{1,4}){1,30}$/', $value);
    }
}