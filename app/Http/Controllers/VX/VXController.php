<?php

namespace App\Http\Controllers\VX;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use \GuzzleHttp\Client;

class VXController extends Controller
{
    //获取access_token
    public function getAccessToken(){
        // 检测是否有缓存
        $key = 'access_token';//设置缓存下表

        $token = Redis::get($key);//查看缓存是否存在

        if($token){
            //如果有的话直接返回缓存的access_token值
        }else{
            //没有调用接口获取access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WX_APPID')."&secret=".env('WX_APPSECRET');//调接口
            $response = file_get_contents($url);//流接受token数据
            $arr = json_decode($response,true);//转换为数组类型数据
            Redis::set($key,$arr['access_token']);// 存缓存
            Redis::expire($key,3600);// 缓存存储事件1小时
            $token = $arr['access_token'];
        }
        return $token;
    }

    //生成参数二维码
    public function ticket(){
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->getAccessToken();
        $arr = [
            'expire_seconds' => 604800,
            'action_name' => 'QR_SCENE',
            'action_info' => [
                'scene' =>[
                    'scene_id' => 123,
                ]
            ]
        ];
        $arr = json_encode($arr , JSON_UNESCAPED_UNICODE);
        $client = new Client();
        $response = $client->request("POST",$url,[
                'body' => $arr
            ]);
        $res = $response->getBody();
        $res = json_decode($res, true);
        $url2 = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$res['ticket'];
        header("Location: $url2");

    }
}
