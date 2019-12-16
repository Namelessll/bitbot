<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBonus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_bonus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('value')->default(0);
            $table->bigInteger('messageId')->default(0);
            $table->bigInteger('userId')->default(0);
            $table->integer('status')->default(0);
            $table->dateTime('dataLast')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_bonus');
    }
}
