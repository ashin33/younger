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
            $table->string('serial_number')->nullable($value = true);
            $table->string('total_price')->nullable($value = true);
            $table->string('preferential_price')->nullable($value = true);
            $table->string('building')->nullable($value = true)->index('building');
            $table->string('floor')->nullable($value = true)->index('floor');
            $table->string('room')->nullable($value = true)->index('room');
            $table->string('contact_person')->nullable($value = true);
            $table->string('phone')->nullable($value = true);
            $table->string('set_meal')->nullable($value = true);
            $table->string('rice_bowl')->nullable($value = true);
            $table->string('soup_pot')->nullable($value = true);
            $table->string('extra_meal')->nullable($value = true);
            $table->string('remark')->nullable($value = true);
            $table->string('extension')->nullable($value = true);
            $table->string('creator_name')->nullable($value = true);
            $table->string('info_filling_duration')->nullable($value = true);
            $table->string('info_region')->nullable($value = true);
            $table->string('info_remote_ip')->nullable($value = true);
            $table->date('order_date')->nullable($value = true)->index('order_date');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable($value = true);
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
