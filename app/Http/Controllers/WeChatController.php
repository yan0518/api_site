<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;

use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use Log;

class WeChatController extends Controller
{


    public function __construct(WechatUserRepositoryEloquent $wechatUserRepository)
    {
        $this->wechatUserRepository = $wechatUserRepository;
    }


    /**
     * event 操作日志
     * @param $message
     * @return array|null|string
     */
    public function EventProcess($message)
    {
        $openid = $message->FromUserName;
        switch ($message->Event) {
            //订阅
            case 'subscribe':

                $wechat = app('wechat.official_account');
                $userService = $wechat->user;

                $wechatUserFromWX = $userService->get($openid);

                $data['subscribe'] = $wechatUserFromWX['subscribe'];
                $data['openID'] = $openid;
                $data['nickname'] = $wechatUserFromWX['nickname'];
                $data['sex'] = $wechatUserFromWX['sex'];
                $data['city'] = $wechatUserFromWX['city'];
                $data['country'] = $wechatUserFromWX['country'];
                $data['province'] = $wechatUserFromWX['province'];
                $data['language'] = $wechatUserFromWX['language'];
                $data['headimgurl'] = $wechatUserFromWX['headimgurl'];
                $data['subscribe_time'] = $wechatUserFromWX['subscribe_time'];
                $data['remark'] = $wechatUserFromWX['remark'];
                $data['groupid'] = $wechatUserFromWX['groupid'];

                $this->wechatUserRepository->updateOrCreate(['openID' => $openid], $data);


//                $material = new Material('mpnews', '1DFH_WiaEfYx78B03Or01B_ekoF_sXi3x7xNrF9Cz5g');
//                Log::info($material);
//                return $material;
                break;
            //取消订阅
            case 'unsubscribe':
                $this->UnsubscribeProcess($openid);
                return '欢迎取消';
                break;
            //已订阅用户扫码
            case 'SCAN':
                break;
            //上报地理位置事件
            case 'LOCATION':
                break;
            //点击菜单拉取消息时的事件推送
            case 'CLICK':
                break;
            //点击菜单跳转链接时的事件推送
            case 'VIEW':
                break;
            default:
                # code...
                break;
        }
        return NULL;
    }

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
                    return self::EventProcess($message);
                    break;
                case 'text':
                    $items = [
                        new NewsItem([
                            'title' => '【外卖优惠共享】全新大改版',
                            'description' => '提高用户体验，大大提高【手气红包】概率',
                            'url' => 'http://mp.weixin.qq.com/s/Ic87Hm4ecKewfG8ZUTTfXg',
                            'image' => 'http://www.3dmgame.com/uploads/allimg/171029/154_171029171922_1.jpg',
                            // ...
                        ]),
                    ];
                    $news = new News($items);
                    return $news;
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