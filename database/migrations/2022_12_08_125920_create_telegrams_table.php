<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegrams', function (Blueprint $table) {
            $table->id();
            $table->integer('telegram_user_id');
            $table->string('telegram_user_name');
            $table->string('trello_user_id')->nullable();
            $table->string('trello_user_name')->nullable();
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
        Schema::dropIfExists('telegrams');
    }
}
