<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class V2OrderDate extends Model
{
    protected $table = 'v2_order_dates';

    protected $fillable = [
        'date',
        'created_at',
        'updated_at',
    ];
}
