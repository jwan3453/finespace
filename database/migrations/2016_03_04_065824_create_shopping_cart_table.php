<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('session',60);
            $table->integer('product_id');
            $table->integer('parent_product_id');
            $table->integer('has_child_product');
            $table->string('product_sku',60);
            $table->integer('count');
            $table->datetime('order_dateTime');
            $table->integer('selected_store');
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
        Schema::drop('shopping_cart');
    }
}
