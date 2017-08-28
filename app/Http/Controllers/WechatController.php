<?php

namespace App\Http\Controllers;
use Config;
use Illuminate\Support\Facades\DB;  //查询构造器的调用
use Illuminate\Http\Request;    //调用Request
use Illuminate\Support\Facades\Session; //调用Session模型
use Illuminate\Support\Facades\Cache;   //调用缓存
use Illuminate\Support\Facades\Log;     //调用错误日志
use EasyWeChat\Foundation\Application;  //实例化easywechat
use App\owner_info;     //MOdel的调用
use EasyWeChat\Broadcast\Broadcast; //调用Broadcast

class WechatController extends Controller
{

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve(Application $wechat)
    {

     $server = $wechat->server;
     $notice = $wechat->notice;
     $messageType = Broadcast::MSG_TYPE_TEXT;
     $broadcast = $wechat->broadcast;
    //  $notice = $wechat->notice;

    // $userId = 'oLiRv1HwbBzQL5NHNr3VB8Ru-1uA';
    // $templateId = 'GlpcaxZK5rscHnXcNdtYE8rTAGwtbkWFuWr22_RTxS4';
    // $url = route('mysql');
    // $data = array(
    //      "first"  => "bilibili",
    //      "name"   => "b站",
    //      "addr"  => "https://www.baidu.com/",
    //      "time" =>date('Y-m-d H:i:s', time()),
    //      "remark" => "welcome！",
    //     );
    // $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
    // var_dump($result);
 
    
    $server->setMessageHandler(function ($message) use($notice,$messageType,$broadcast){
    // $message->FromUserName // 用户的 openid
    // $message->MsgType // 消息类型：event, text....
 
    switch ($message->MsgType) {
            case 'event':
                        $txt=$message->EventKey;
                        if($txt!=null&&($message->Event=='SCAN'||$message->Event=='subscribe')){ 
                            $time=date("Y-m-d H:i:s",time());
                            $check=substr($txt,0,8);
                            if($check=='qrscene_'){
                                $txt=substr($txt,8);

                            }
                            $userId = $message->FromUserName;
                            $mgs=owner_info::where('discern','=',$txt)->first();
                            if($mgs==null){
                                $templateId = 'c1c5JiCyRnNkpARMdGP1wR8_U7ljDbcZUUjhGbyb6n8';
                                $url = route('from').'?discern='.$txt;
                                $data = array(
                                         "first"  => "欢迎使用owner！",
                                         "remark" =>$time,
                                        );
                                $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
                            }else{
                                if($mgs->statu!=1){
                                    $mgs->name='未公开';
                                    $mgs->wechat='未公开';
                                    $mgs->phone='未公开';
                                }
                                $templateId = '5efyr7xL256QR-5LBJQDiavtcVpImq1mKYXeBIJHTO0';
                                $url = route('from').'?discern='.$txt;
                                $data = array(
                                         "first"  => "谢谢你的热心帮助！",
                                         "name"   => $mgs->name,
                                         "wechat"  => $mgs->wechat,
                                         "phone" => $mgs->phone,
                                         "remark" =>$time,
                                        );
                                $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

                                
                                $openId=$mgs->opid;
                                $name=$mgs->name;
                                $openId1='123123okl';
                                $message=$time.'-'.$name.'被扫描';
                                
                                $broadcast->send($messageType, $message, [$openId, $openId1]);
                            }
                           
                          
                        }
                        else{
                            $txt='Hi,owner';
                            return $txt;
                        }
                        
                break;
            case 'text':
                return 'Hi,owner';
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
            // ... 其它消息
            default:
                return '收到其它消息';
                break;
        }    
    });
    $response = $server->serve();


    return $response; // Laravel 里请使用：return $response;
    
    
    }

    public function demo(Application $wechat){

        $menu = $wechat->menu;
        $buttons = [
            [
                "type" => "view",
                "name" => "owner",
                "url"  => "http://www.passowner.club/owner/public"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "个人页面",
                        "url"  => "http://www.passowner.club/owner/public/person"
                    ],
                    [
                        "type" => "view",
                        "name" => "GitHub",
                        "url"  => "https://github.com/FYKANG/owner"
                    ],
                ],
            ],
        ];
        $menu->add($buttons);      
    }
}