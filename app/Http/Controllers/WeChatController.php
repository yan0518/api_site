<?php

namespace App\Http\Controllers;

use App\Repositories\WechatUsersRepositoryEloquent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;

use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Text;
use Log;

class WeChatController extends Controller
{


    public function __construct(WechatUsersRepositoryEloquent $wechatUserRepository)
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

                return '欢迎关注';
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
     * 用户取消关注
     * @param $message
     * @return null
     */
    private function UnsubscribeProcess($openid)
    {
        $user_info = $this->wechatUserRepository->findWhere(['openID' => $openid])->first();
        $this->wechatUserRepository->update(['subscribe' => 0], $user_info->id);
        return NULL;
    }


    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    return self::EventProcess($message);
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                default:
                    return '收到其它消息';
                    break;
            }

        });
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