<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('country');
            $table->integer('province');
            $table->integer('city');
            $table->integer('district');
            $table->string('address');
            $table->string('post_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_address');
    }
}
