<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\V1Order;
use App\Models\OrderDate;
use App\Models\Printer;
use App\Models\V2Order;
use App\Service\YiLianYunService\ApplicationService;
use App\Service\YiLianYunService\PrintService;
use Illuminate\Http\Request;

class YoungerController extends Controller
{

    public function orderEntry(Request $request)
    {
        echo 'success';
        fastcgi_finish_request();

        $data = $request->all();
        $entry = $data['entry'];

        $serial_number = $entry['serial_number'] ?? null;//序号
        $total_price = $entry['total_price'] ?? null;//应付金额
        $preferential_price = $entry['preferential_price'] ?? null;//优惠金额
        $meal_mode = $entry['meal_mode'] ?? null;//取餐方式
        $name = $entry['field_15'] ?? null;//姓名
        $phone = $entry['field_9'] ?? null;//手机号
        $address = $entry['field_10'] ?? null;//地址
        $desk_num = $entry['field_16'] ?? null;//桌号
        $home_cooking = $entry['field_5'] ? json_encode($entry['field_5'], JSON_UNESCAPED_UNICODE) : null;//家常小炒
        $hard_dish = $entry['field_11'] ? json_encode($entry['field_11'], JSON_UNESCAPED_UNICODE) : null;//来盘儿硬菜
        $fish = $entry['field_4'] ? json_encode($entry['field_4'], JSON_UNESCAPED_UNICODE) : null;//天天有鱼
        $egg = $entry['field_12'] ? json_encode($entry['field_12'], JSON_UNESCAPED_UNICODE) : null;//简蛋不简单
        $fried_rice = $entry['field_13'] ? json_encode($entry['field_13'], JSON_UNESCAPED_UNICODE) : null;//经典炒饭
        $griddle = $entry['field_3'] ? json_encode($entry['field_3'], JSON_UNESCAPED_UNICODE) : null;//干饭人爱干锅
        $soup = $entry['field_14'] ? json_encode($entry['field_14'], JSON_UNESCAPED_UNICODE) : null;//该喝汤了
        $remark = $entry['field_7'] ?? null;//备注
        $extension = $entry['x_field_1'] ?? null;//扩展属性
        $creator_name = $entry['creator_name'] ?? null;//提交人
        $order_created_at = $entry['created_at'] ?? date('Y-m-d H:i:s');//提交时间
        $order_updated_at = $entry['updated_at'] ?? date('Y-m-d H:i:s');//修改时间
        $info_filling_duration = $entry['info_filling_duration'] ?? null;//填写时长
        $info_region = $entry['info_region'] ?? null;//填写地区
        $info_remote_ip = $entry['info_remote_ip'] ?? null;//IP

        //订单入库
        $order = new V2Order();
        $order->fill([
            'serial_number' => $serial_number,
            'total_price' => $total_price,
            'preferential_price' => $preferential_price,
            'meal_mode' => $meal_mode,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'desk_num' => $desk_num,
            'home_cooking' => $home_cooking,
            'hard_dish' => $hard_dish,
            'fish' => $fish,
            'egg' => $egg,
            'fried_rice' => $fried_rice,
            'griddle' => $griddle,
            'soup' => $soup,
            'remark' => $remark,
            'extension' => $extension,
            'creator_name' => $creator_name,
            'info_filling_duration' => $info_filling_duration,
            'info_region' => $info_region,
            'info_remote_ip' => $info_remote_ip,
            'order_date' => date('Y-m-d'),
            'order_created_at' => $order_created_at,
            'order_updated_at' => $order_updated_at,
        ]);
        $order->save();

        $canPrint = true;
        $application = Application::getEnabledApplication();
        if(!empty($application)){
            $application_service = new ApplicationService($application);
            $access_token = $application_service->getToken();
            $config = $application_service->getConfig();
            $print_service = new PrintService($access_token, $config);
            $printer = Printer::getEnabledPrinter();
            if(empty($printer)){
                $canPrint = false;
            }else{
                $machine_code = $printer->getMachineCode();
            }
        }else{
            $canPrint = false;
        }

        if($canPrint){
            $res = $print_service->print($machine_code, $order);
            if ($print_service->isSuccess($res)) {
                $order->setPrintSuccess();
            } else {
                $order->setPrintFAIL($print_service->getErrorMsg());
            }
        }else{
            $order->setPrintWaiting();
        }


        OrderDate::query()->updateOrCreate([
            'date' => date('Y-m-d')
        ], [
            'date' => date('Y-m-d'),
            'created' => date('Y-m-d H:i:s')
        ]);

    }

}
