<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrellosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trellos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('telegram_id')->unsigned();
            $table->string('card_id');
            $table->string('card_name');
            $table->string('card_status')->nullable();
            $table->timestamps();
            $table->foreign('telegram_id')->references('id')->on('telegrams')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trellos');
    }
}
