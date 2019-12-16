<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBotUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_bot_users', function (Blueprint $table) {
            $table->bigIncrements('telegramId');
            $table->string('telegramUsername')->nullable();
            $table->double('balance')->default(0);
            $table->integer('referalCount')->default(0);
            $table->bigInteger('inviteId')->default(0);
            $table->boolean('ban')->default(0);
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
        Schema::dropIfExists('table_bot_users');
    }
}
