<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Applications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('应用名称');
            $table->string('client_id')->comment('应用ID');
            $table->string('client_secret')->comment('应用密钥');
            $table->string('access_token')->nullable($value = true)->comment('access_token');
            $table->string('status',16)->comment('启用状态');
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
        Schema::drop('applications');
    }
}
