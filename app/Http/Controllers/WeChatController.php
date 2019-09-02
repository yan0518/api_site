<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;

use EasyWeChat\Kernel\Messages\News;
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

        $wechat = app('wechat.official_account');
        $wechat->server->setMessageHandler(function ($message) use ($wechat) {
            log::info($message);
            switch ($message->MsgType) {
                case 'event':
                    break;
                case 'text':
                    $a[] = new News([
                        'title' => '【外卖优惠共享】全新大改版',
                        'description' => '提高用户体验，大大提高【手气红包】概率',
                        'url' => 'http://mp.weixin.qq.com/s/Ic87Hm4ecKewfG8ZUTTfXg',
                        'image' => 'http://www.3dmgame.com/uploads/allimg/171029/154_171029171922_1.jpg',
                    ]);
                    return $a;
                    break;
                case 'image':
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
////        $app->server->push(function($message){
////            return "欢迎关注！";
//        });
        return $app->server->serve();

    }

    public function qrcode($uuid)
    {
        $wechat = app('wechat.official_account');
        $result = $wechat->qrcode->forever($uuid);

        $url = $result->url ?? 'http://www.pigzu.com';

        return $this->SuccessResponse($url);
    }
}