<?php


namespace App\Service\YiLianYunService;


class PrinterService extends \App\Api\PrinterService
{
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
}