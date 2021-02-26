<?php


namespace App\Service\YiLianYunService;


use App\Config\YlyConfig;
use App\Models\Order;
use App\Protocol\YlyRpcClient;
use Illuminate\Support\Str;

class PrintService extends \App\Api\PrintService
{
    protected $access_token;
    protected $config;

    public function __construct($access_token, YlyConfig $config)
    {
        $this->access_token = $access_token;
        $this->config = $config;
        parent::__construct($access_token, $config);
    }

    public function isSuccess($res): bool
    {
        $code = $res->error;
        return $code === '0';
    }

    public function isFail($res): bool
    {
        $code = $res->error;
        return $code != '0';
    }

    public function getErrorMsg($res)
    {
        return $res->error_description;
    }

    public function print($machine_code,Order $order)
    {
        $printService = new PrintService($this->access_token, $this->config);
        $content = $order->getContent();
        return  $printService->index($machine_code, $content, Str::random(32));
    }
}