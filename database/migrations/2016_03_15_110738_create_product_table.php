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
            $table->decimal('price',10,2);
            $table->decimal('promote_price',10,2);
            $table->dateTime('promote_start_date');
            $table->dateTime('promote_end_date');
            $table->integer('status');
            $table->integer('is_promote');
            $table->integer('stock_alarm');
            $table->string('keywords');
            $table->string('brief');
            $table->text('desc');
            $table->string('thumb');
            $table->string('img');
            $table->string('is_new',2);
            $table->string('is_hot',2);
            $table->string('is_recommend',2);


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
