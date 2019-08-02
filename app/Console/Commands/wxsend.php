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
        $arr1=[
            '这世界要是没有爱情，它在我们心中还会有什么意义！这就如一盏没有亮光的走马灯。 —— 歌德',
            '爱情原如树叶一样，在人忽视里绿了，在忍耐里露出蓓蕾。 —— 何其芳',
            '爱情只有当它是自由自在时，才会叶茂花繁。认为爱情是某种义务的思想只能置爱情于死地。只消一句话：你应当爱某个人，就足以使你对这个人恨之入骨。 —— 罗素',
            '毫无经验的初恋是迷人的，但经得起考验的爱情是无价的。 —— 马尔林斯基',
            '酒杯里竟能蹦出友谊来。 —— 盖伊',
            '世界上一成不变的东西，只有“任何事物都是在不断变化的”这条真理。 —— 斯里兰卡',
            '从不浪费时间的人，没有工夫抱怨时间不够。 —— 杰弗逊',
            '她们把自己恋爱作为终极目标，有了爱人便什么都不要了，对社会作不了贡献，人生价值最少。 —— 向警予',
            '成功的秘诀，在永不改变既定的目的。 —— 卢梭',
            '忠诚可以简练地定义为对不可能的情况的一种不合逻辑的信仰。 —— 门肯'
        ];
        $text=array_rand($arr1);
        $con=$arr1[$text].date('Y-m-d H:i:s');
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
