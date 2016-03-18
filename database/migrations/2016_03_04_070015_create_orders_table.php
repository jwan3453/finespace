<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
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
            $table->string('order_no',30);
            $table->integer('user_id');
            $table->integer('address_id');
            $table->integer('recipient_id');
            $table->integer('shipping_id');
            $table->integer('payment_id');
            $table->dateTime('delivery_time');
            $table->decimal('total_amount',10,2);
            $table->decimal('shipping_fee',10,2);
            $table->integer('status');
            $table->integer('shipping_status');
            $table->integer('pay_status');
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
        Schema::drop('orders');
    }
}
