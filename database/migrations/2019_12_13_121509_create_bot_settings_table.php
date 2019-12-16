<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         <!-- Каптча для регистрации нового пользователя -->
                            <!-- Приветственная форма -->

                            <!-- Сумма за регистрацию -->
                            <!-- Минимальная сумма для вывода -->
                            <!-- Значения для выплат -->
                            <!-- Количество сатоши за реферала -->
                            <!-- Процент выплат с каждого реферала -->
         * */
        Schema::create('bot_settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('Registration_question')->nullable();
            $table->string('Registration_answer')->nullable();

            $table->longText('Welcome_message')->nullable();

            $table->double('Registration_sum')->default(0);

            $table->double('Minimal_windrow_sum')->default(0);

            $table->double('Random_sum_start')->default(0);
            $table->double('Random_sum_end')->default(0);

            $table->double('Referal_sum')->default(0);

            $table->integer('Referal_procent')->default(0);

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
        Schema::dropIfExists('bot_settings');
    }
}
