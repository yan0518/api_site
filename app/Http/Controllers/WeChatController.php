<?php

namespace App\Http\Controllers;

use Log;

class WeChatController extends Controller
{

    /**
     * 微信服务器连接
     * @param Request $request
     * @return mixed
     */
    public function Connection(Request $request)
    {

        $wechat =app('wechat.official_account');
        $wechat->server->setMessageHandler(function ($message) use ($wechat) {
            log::info($message);
            switch ($message->MsgType) {
                case 'event':
                    break;
                case 'text':
                    break;
                case
                'image':
                    # 图片消息...
                    break;
                case 'voice':
                    # 语音消息...
                    break;
                case 'link':
                    break;
                default:
                    # code...
                    break;
            }
        });
        return $wechat->server->serve();
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
//        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
//        $app->server->push(function($message){
//            return "欢迎关注 overtrue！";
//        });
        return $app->server->serve();
        die;

    }
}