<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table)
    {
        $table->string('first_name')->after('name');
        $table->string('last_name')->after('first_name');
        $table->integer('unit_no')->after('last_name');
        $table->string('building_name')->after('unit_no');
        $table->string('city')->after('building_name');
        $table->string('region')->after('city');
        $table->string('street')->after('region');
        $table->integer('post_code')->after('street');
        $table->string('country')->after('post_code');
        $table->date('dob')->after('country');
        $table->string('mobile_no')->after('dob');
        $table->string('landline_no')->after('mobile_no');
        $table->tinyInteger('is_active')->after('landline_no')->default('1');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table)
            {
               $table->dropColumn('first_name');
               $table->dropColumn('last_name');
               $table->dropColumn('unit_no');
               $table->dropColumn('building_name');
               $table->dropColumn('city');
               $table->dropColumn('region');
               $table->dropColumn('street');
               $table->dropColumn('post_code');
               $table->dropColumn('country');
               $table->dropColumn('dob');
               $table->dropColumn('mobile_no');
               $table->dropColumn('landline_no');
               $table->dropColumn('is_active');
            });
    }
}
