<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('type');
            $table->integer('prod_article_id');
            $table->integer('user_id');
            $table->text('content');
            $table->dateTime('publish_time');
            $table->string('ip_address',30);
            $table->integer('status');
            $table->integer('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comment');
    }
}
