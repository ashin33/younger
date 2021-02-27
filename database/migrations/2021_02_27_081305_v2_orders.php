<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class V2Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number')->nullable($value = true)->comment('序号');
            $table->string('total_price')->nullable($value = true)->comment('应付金额');
            $table->string('preferential_price')->nullable($value = true)->comment('优惠金额');
            $table->string('meal_mode')->nullable($value = true)->comment('取餐方式');
            $table->string('name')->nullable($value = true)->comment('姓名');
            $table->string('phone')->nullable($value = true)->comment('手机号');
            $table->string('address')->nullable($value = true)->comment('地址');
            $table->string('desk_num')->nullable($value = true)->comment('桌号');

            $table->json('home_cooking')->nullable($value = true)->comment('家常小炒');
            $table->json('hard_dish')->nullable($value = true)->comment('来盘儿硬菜');
            $table->json('fish')->nullable($value = true)->comment('天天有鱼');
            $table->json('egg')->nullable($value = true)->comment('简蛋不简单');
            $table->json('fried_rice')->nullable($value = true)->comment('经典炒饭');
            $table->json('griddle')->nullable($value = true)->comment('干饭人爱干锅');
            $table->json('soup')->nullable($value = true)->comment('该喝汤了');
            
            
            $table->string('remark')->nullable($value = true)->comment('备注');
            $table->string('extension')->nullable($value = true)->comment('扩展属性');
            $table->string('creator_name')->nullable($value = true)->comment('提交人');
            $table->string('info_filling_duration')->nullable($value = true)->comment('填写时长');
            $table->string('info_region')->nullable($value = true)->comment('填写地区');
            $table->string('info_remote_ip')->nullable($value = true)->comment('ip');
            $table->string('order_created_at')->nullable($value = true)->comment('接口返回的订单创建日期');
            $table->string('order_updated_at')->nullable($value = true)->comment('接口返回的订单更新日期');
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
        Schema::drop('v2_orders');
    }
}
