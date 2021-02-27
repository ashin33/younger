<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class V1Order extends Model implements Order
{
    protected $table = 'orders';

    protected $fillable = [
        'serial_number',
        'total_price',
        'preferential_price',
        'building',
        'floor',
        'room',
        'contact_person',
        'phone',
        'set_meal',
        'rice_bowl',
        'soup_pot',
        'extra_meal',
        'remark',
        'extension',
        'creator_name',
        'info_filling_duration',
        'info_region',
        'info_remote_ip',
        'order_date',
        'print_status',
        'reason',
        'created_at',
        'updated_at',
    ];

    const PRINT_WAITING = 'waiting';
    const PRINT_PROCESSING = 'processing';
    const PRINT_SUCCESS = 'success';
    const PRINT_FAIL = 'fail';

    public static $print_status = [
        'waiting' => [
            'text' => '未打印',
            'icon' => 'fa-circle text-success'
        ],
        'processing' => [
            'text' => '打印中',
            'icon' => 'fa-circle text-warning'
        ],
        'success' => [
            'text' => '已打印',
            'icon' => 'fa-circle text-navy'
        ],
        'fail' => [
            'text' => '打印失败',
            'icon' => 'fa-circle text-danger'
        ]
    ];


    public function printStatusDisplay($type = 'text'): string
    {
        $print_status = $this->getAttribute('print_status');
        if (!isset(self::$print_status[$print_status])) {
            return "未定义[{$print_status}]";
        }
        return self::$print_status[$print_status][$type] ?? "未知[{$type}]";
    }

    public function getContent()
    {
        //58mm排版 排版指令详情请看 http://doc2.10ss.net/332006
        $content = "<FS2><center>**#1 新华紫箸**</center></FS2>";
        $content .= str_repeat('.', 32);
        $content .= "<FS2><center>--younger_test--</center></FS2>";
        $content .= "<FS><center>order</center></FS>";
        $content .= "订单时间:". $this->getAttribute('created_at') . "\n";
        $content .= "订单编号:".$this->getAttribute('serial_number')."\n";
        $content .= "<table>";
        $content .= "<tr><td>".$this->getAttribute('set_meal')."</td><td>x1</td></tr>";
        $content .= "<tr><td>".$this->getAttribute('rice_bowl')."</td><td>x1</td></tr>";
        $content .= "<tr><td>".$this->getAttribute('soup_pot')."</td><td>x1</td></tr>";
        $content .= "<tr><td>".$this->getAttribute('extra_meal')."</td><td>x1</td></tr>";
        $content .= "备注:".$this->getAttribute('remark')."\n";
        $content .= "</table>";
        $content .= str_repeat('.', 32);
        $content .= "<QR>这是二维码内容</QR>";
        $content .= str_repeat('*', 32);
        $content .= "联系人:".$this->getAttribute('contact_person')."\n";
        $content .= "联系电话:".$this->getAttribute('phone')."\n";
        $content .= "<FS2><center>**#1 完**</center></FS2>";
        return $content;
    }

    public function setPrintWaiting()
    {
        $this->setAttribute('print_status', self::PRINT_WAITING);
        $this->save();
    }

    public function setPrintSuccess()
    {
        $this->setAttribute('print_status', self::PRINT_SUCCESS);
        $this->save();
    }

    public function setPrintFAIL($reason = null)
    {
        $this->setAttribute('print_status', self::PRINT_SUCCESS);
        $this->setAttribute('reason', $reason);
        $this->save();
    }
}
