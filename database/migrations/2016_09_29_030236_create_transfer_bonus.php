<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferBonus extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transferbonus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id');
            $table->string('currency_code');
            $table->double('from');
            $table->double('to');
            $table->double('rate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('transferbonus');
    }

}
