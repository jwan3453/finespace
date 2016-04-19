<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdSlideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_slide', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');//1 封面
            $table->string('key',512);
            $table->string('link',512);
            $table->string('ad_link',512);
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
        Schema::drop('ad_slide');
    }
}
