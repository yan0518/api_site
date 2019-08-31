<?php
/**
 * Created by PhpStorm.
 * User: lsj
 * Date: 2018/11/13
 * Time: 09:35
 */

namespace App\Helper;

use Illuminate\Support\Facades\App;

class EnvHelper{
    /**
     * 是否是生产环境
     * @return bool
     */
    public static function isProductionEnv(){
        return App::environment('production');
    }


    /**
     * 是否是本地环境
     * @return bool
     */
    public static function isLocalEnv(){
        return App::environment('local');
    }


    /**
     * 是否是内置web
     * @return bool
     */
    public static function isInternalWeb(){
        return 'internal' == config('smartapp.run_env');
    }


    /**
     * 是否是云端web
     * @return bool
     */
    public static function isCloudWeb(){
        return 'cloud' == config('smartapp.run_env');
    }
}