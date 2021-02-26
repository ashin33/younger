<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number')->nullable($value = true)->comment('订单号');
            $table->string('total_price')->nullable($value = true)->comment('应付金额');
            $table->string('preferential_price')->nullable($value = true)->comment('优惠金额');
            $table->string('building')->nullable($value = true)->index('building')->comment('楼号');
            $table->string('floor')->nullable($value = true)->index('floor')->comment('楼层');
            $table->string('room')->nullable($value = true)->index('room')->comment('科室');
            $table->string('contact_person')->nullable($value = true)->comment('联系人');
            $table->string('phone')->nullable($value = true)->comment('电话');
            $table->string('set_meal')->nullable($value = true)->comment('套餐');
            $table->string('rice_bowl')->nullable($value = true)->comment('盖浇饭');
            $table->string('soup_pot')->nullable($value = true)->comment('汤煲');
            $table->string('extra_meal')->nullable($value = true)->comment('加饭');
            $table->string('remark')->nullable($value = true)->comment('备注');
            $table->string('extension')->nullable($value = true)->comment('扩展属性');
            $table->string('creator_name')->nullable($value = true)->comment('提交人');
            $table->string('info_filling_duration')->nullable($value = true)->comment('填写时长');
            $table->string('info_region')->nullable($value = true)->comment('填写地区');
            $table->string('info_remote_ip')->nullable($value = true)->comment('ip');
            $table->date('order_date')->nullable($value = true)->comment('access_token')->index('下单日期');
            $table->timestamp('created_at')->useCurrent()->comment('创建时间');
            $table->timestamp('updated_at')->nullable($value = true)->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
