<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserFrame extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_user_frame', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userId')->default(0);
            $table->boolean('paymentFrame')->default(0);
            $table->boolean('bonusFrame')->default(0);
            $table->boolean('questionFrame')->default(0);
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
        Schema::dropIfExists('table_user_frame');
    }
}
