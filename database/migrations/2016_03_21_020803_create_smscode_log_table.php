<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmscodeLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smsCode_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile',20);
            $table->string('smsCode',6);
            $table->string('type',10);
            $table->string('detail');
            $table->timestamp('expire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('smsCode_log');
    }
}
