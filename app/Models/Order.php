<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
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
        'created_at',
        'updated_at',
    ];
}
