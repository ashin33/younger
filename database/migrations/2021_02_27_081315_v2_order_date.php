<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class V2OrderDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_order_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable($value = true)->comment('订单日期');
            $table->timestamp('created_at')->useCurrent()->comment('创建日期');
            $table->timestamp('updated_at')->nullable($value = true)->comment('更新日期');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('v2_order_dates');
    }
}
