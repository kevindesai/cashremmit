<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipientMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipientmaster', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('city_name');
            $table->string('mobile_no');
            $table->string('country_name');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('bank_code');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('suburb');
            $table->string('phone_no');
            $table->string('email');
            $table->string('region');
            $table->string('branch_state');
            $table->string('branch');
            $table->string('branch_code');
            $table->text('attributes');
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
        Schema::drop('recipientmaster');
    }
}
