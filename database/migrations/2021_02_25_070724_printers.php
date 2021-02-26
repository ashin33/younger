<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Printers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id')->nullable($value = true)->comment('所授权的应用id');
            $table->string('name')->comment('打印机名称');
            $table->string('machine_code')->comment('打印机终端号');
            $table->string('m_sign')->comment('打印机秘钥');
            $table->string('status',16)->comment('启用状态');
            $table->string('auth_status',16)->comment('授权状态');
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
        Schema::drop('printers');
    }
}
