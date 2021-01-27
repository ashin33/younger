<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDate extends Model
{
    protected $table = 'order_dates';

    protected $fillable = [
        'date',
        'created_at',
        'updated_at',
    ];
}
