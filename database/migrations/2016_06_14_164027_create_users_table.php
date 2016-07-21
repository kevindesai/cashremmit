<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateusersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('unit_no');
            $table->string('building_name');
            $table->string('city');
            $table->string('region');
            $table->string('street');
            $table->integer('post_code');
            $table->string('country');
            $table->date('dob');
            $table->string('mobile_no');
            $table->string('landline_no');
            $table->tinyInteger('is_active')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }

}
