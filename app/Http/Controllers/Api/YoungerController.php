<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDate;
use Illuminate\Http\Request;

class YoungerController extends Controller
{
    protected $food_arr = [];

    public function orderEntry(Request $request)
    {
        echo 'success';
        fastcgi_finish_request();
        date_default_timezone_set('Asia/Shanghai');
        $created_at = date("Y-m-d H:i:s");
        $time = time();

        if($time >= strtotime(date('Y-m-d 18:00:00'))){
            $order_date = date('Y-m-d', strtotime('+1 day'));
        }else{
            $order_date = date('Y-m-d');
        }
        $data = $request->all();
        $entry = $data['entry'];

        $department = $entry['field_12'] ?? [];//科室
        $building = $department['level_1'] ?? null;
        $floor_room = $department['level_2'] ?? null;
        $index = strrpos($floor_room, '层');
        if(!$index){
            $index = strrpos($floor_room, '楼');
        }
        if($index){
           $floor = mb_substr($floor_room, 0, $index);
           $room = mb_substr($floor_room, $index+2 );
        }else{
            $floor = $floor_room;
            $room = '';
        }
        $set_meals = $entry['field_3'] ?? [];//套餐
        $rice_bowls = $entry['field_5'] ?? [];//盖浇饭
        $soup_pots = $entry['field_11'] ?? [];//汤煲
        $extra_meals = $entry['field_10'] ?? [];//加份饭
        $order_insert_data = [];
        foreach ($set_meals as $key => $value) {
            for ($i = 1; $i <= $value['number']; $i++) {
                $order_insert_data[] = [
                    'serial_number' => $entry['serial_number'] ?? null,
                    'total_price' => $entry['total_price'] ?? null,
                    'preferential_price' => $entry['preferential_price'] ?? null,
                    'building' => $building,
                    'floor' => $floor,
                    'room' => $room,
                    'contact_person' => $entry['field_2'] ?? null,
                    'phone' => $entry['field_9'] ?? null,
                    'set_meal' => $value['name'] . '-'. $i,
                    'rice_bowl' => null,
                    'soup_pot' => null,
                    'extra_meal' => null,
                    'remark' => $entry['field_8'] ?? null,
                    'extension' => $entry['x_field_1'] ?? null,
                    'creator_name' => $entry['creator_name'] ?? null,
                    'info_filling_duration' => $entry['info_filling_duration'] ?? null,
                    'info_region' => $entry['info_region'] ?? null,
                    'info_remote_ip' => $entry['info_remote_ip'] ?? null,
                    'order_date' => $order_date,
                    'created_at' => $created_at,
                    'updated_at' => null,
                ];
            }
        }
        foreach ($rice_bowls as $key => $value) {
            for ($i = 1; $i <= $value['number']; $i++) {
                $order_insert_data[] = [
                    'serial_number' => $entry['serial_number'] ?? null,
                    'total_price' => $entry['total_price'] ?? null,
                    'preferential_price' => $entry['preferential_price'] ?? null,
                    'building' => $building,
                    'floor' => $floor,
                    'room' => $room,
                    'contact_person' => $entry['field_2'] ?? null,
                    'phone' => $entry['field_9'] ?? null,
                    'set_meal' => null,
                    'rice_bowl' => $value['name'] . '-'. $i,
                    'soup_pot' => null,
                    'extra_meal' => null,
                    'remark' => $entry['field_8'] ?? null,
                    'extension' => $entry['x_field_1'] ?? null,
                    'creator_name' => $entry['creator_name'] ?? null,
                    'info_filling_duration' => $entry['info_filling_duration'] ?? null,
                    'info_region' => $entry['info_region'] ?? null,
                    'info_remote_ip' => $entry['info_remote_ip'] ?? null,
                    'order_date' => $order_date,
                    'created_at' => $created_at,
                    'updated_at' => null,
                ];
            }
        }
        foreach ($soup_pots as $key => $value) {
            for ($i = 1; $i <= $value['number']; $i++) {
                $order_insert_data[] = [
                    'serial_number' => $entry['serial_number'] ?? null,
                    'total_price' => $entry['total_price'] ?? null,
                    'preferential_price' => $entry['preferential_price'] ?? null,
                    'building' => $building,
                    'floor' => $floor,
                    'room' => $room,
                    'contact_person' => $entry['field_2'] ?? null,
                    'phone' => $entry['field_9'] ?? null,
                    'set_meal' => null,
                    'rice_bowl' => null,
                    'soup_pot' => $value['name'] . '-'. $i,
                    'extra_meal' => null,
                    'remark' => $entry['field_8'] ?? null,
                    'extension' => $entry['x_field_1'] ?? null,
                    'creator_name' => $entry['creator_name'] ?? null,
                    'info_filling_duration' => $entry['info_filling_duration'] ?? null,
                    'info_region' => $entry['info_region'] ?? null,
                    'info_remote_ip' => $entry['info_remote_ip'] ?? null,
                    'order_date' => $order_date,
                    'created_at' => $created_at,
                    'updated_at' => null,
                ];
            }
        }
        foreach ($extra_meals as $key => $value) {
            for ($i = 1; $i <= $value['number']; $i++) {
                $order_insert_data[] = [
                    'serial_number' => $entry['serial_number'] ?? null,
                    'total_price' => $entry['total_price'] ?? null,
                    'preferential_price' => $entry['preferential_price'] ?? null,
                    'building' => $building,
                    'floor' => $floor,
                    'room' => $room,
                    'contact_person' => $entry['field_2'] ?? null,
                    'phone' => $entry['field_9'] ?? null,
                    'set_meal' => null,
                    'rice_bowl' => null,
                    'soup_pot' => null,
                    'extra_meal' => $value['name'] . '-'. $i,
                    'remark' => $entry['field_8'] ?? null,
                    'extension' => $entry['x_field_1'] ?? null,
                    'creator_name' => $entry['creator_name'] ?? null,
                    'info_filling_duration' => $entry['info_filling_duration'] ?? null,
                    'info_region' => $entry['info_region'] ?? null,
                    'info_remote_ip' => $entry['info_remote_ip'] ?? null,
                    'order_date' => $order_date,
                    'created_at' => $created_at,
                    'updated_at' => null,
                ];
            }
        }
        Order::query()->insert($order_insert_data);
        OrderDate::query()->updateOrCreate([
            'date' => $order_date
        ],[
            'date' => $order_date,
            'created' => date('Y-m-d H:i:s')
        ]);
    }

    public function getYiLianYunCode(Request $request)
    {

    }
}
