<?php

namespace Tests\Unit;

use App\Api\PrinterService;
use App\Api\PrintService;
use App\Config\YlyConfig;
use App\Oauth\YlyOauthClient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    protected $clientId = '1086073112';
    protected $clientSecret = '47419eac44bebfb4147c154e9bfed385';

    protected $machineCode = '4004716049';
    protected $mSign = '206926033383';

    protected $accessToken = '7861a419afa34f959f4ac0238f501195';

    public function getConfig(): YlyConfig
    {
        return new YlyConfig($this->clientId, $this->clientSecret);
    }

    public function testToken()
    {
        $config = $this->getConfig();
        $client = new YlyOauthClient($config);
        try {
            $token = $client->getToken();
            print_r($token);
            print_r($token->access_token);
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            print_r(json_decode($e->getMessage(), true));
            return;
        }
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPrintText()
    {
        $config = $this->getConfig();


        /**文本接口开始**/
        $print = new PrintService($this->accessToken, $config);
        //58mm排版 排版指令详情请看 http://doc2.10ss.net/332006
        $content = "<FS2><center>**#1 测试没纸会咋样**</center></FS2>";
        $content .= str_repeat('.', 32);
        $content .= "<FS2><center>--younger_test--</center></FS2>";
        $content .= "<FS><center>order</center></FS>";
        $content .= "订单时间:". date("Y-m-d H:i") . "\n";
        $content .= "订单编号:youngerTest\n";
        $content .= str_repeat('*', 14) . "商品" . str_repeat("*", 14);
        $content .= "<table>";
        $content .= "<tr><td>烤土豆(超级辣)</td><td>x3</td><td>5.96</td></tr>";
        $content .= "<tr><td>烤豆干(超级辣)</td><td>x2</td><td>3.88</td></tr>";
        $content .= "<tr><td>烤鸡翅(超级辣)</td><td>x3</td><td>17.96</td></tr>";
        $content .= "<tr><td>烤排骨(香辣)</td><td>x3</td><td>12.44</td></tr>";
        $content .= "<tr><td>烤韭菜(超级辣)</td><td>x3</td><td>8.96</td></tr>";
        $content .= "</table>";
        $content .= str_repeat('.', 32);
        $content .= "<QR>这是二维码内容</QR>";
        $content .= "小计:￥82\n";
        $content .= "折扣:￥４ \n";
        $content .= str_repeat('*', 32);
        $content .= "订单总价:￥78 \n";
        $content .= "<FS2><center>**#1 完**</center></FS2>";

        try{
            var_dump($print->index($this->machineCode, $content, 'youngerTest'));
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testAuth()
    {
        $config = $this->getConfig();
    //授权打印机(自有型应用使用,开放型应用请跳过该步骤)
        $printer = new PrinterService($this->accessToken, $config);
        $data = $printer->addPrinter($this->machineCode, $this->mSign, 'order');
        var_dump($data);
    }
}
