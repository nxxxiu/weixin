<?php

namespace App\Console\Commands;

use App\wxUser;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class wxsend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wx:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'wechat send everybody';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.getWxAccessToken();
        $openid=wxUser::get()->toArray();
        $openid=array_column($openid,'openid');
        $text="hello Brown";
        $con=$text.date('Y-m-d H:i:s');
        $arr=[
            'touser'=>[
                $openid
            ],
            'msgtype'=>'text',
            'text'=>[
                'content'=>$con
            ]
        ];
        $str=json_encode($arr,JSON_UNESCAPED_UNICODE);
        $client=new Client();
        $response=$client->request('POST',$url,[
            'body'=>$str
        ]);
        if(json_decode($response->getBody(),true)['errcode']==0){
            echo '发送成功';
        }else{
            echo '发送失败';
        }
    }
}
