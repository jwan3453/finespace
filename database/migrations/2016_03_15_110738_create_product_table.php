<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('sku',60);
            $table->string('name',120);
            $table->integer('brand_id');
            $table->integer('inventory');
            $table->integer('limit_per_day');
            $table->decimal('price',10,2);
            $table->decimal('promote_price',10,2);
            $table->dateTime('promote_start_date');
            $table->dateTime('promote_end_date');
            $table->integer('status');
            $table->integer('is_promote');
            $table->integer('is_new');
            $table->integer('is_hot');
            $table->integer('is_recommend');
            $table->integer('stock_alarm');
            $table->integer('type');//1为单品 2为套餐
            $table->string('keywords');
            $table->string('brief');
            $table->text('desc');
            $table->string('thumb');
            $table->string('img');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product');
    }
}
