<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRecipent extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('recipientmaster', function($table) {
            $table->string('middle_name');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('suburb');
            $table->string('phone_no');
            $table->string('email');
            $table->string('region');
            $table->string('branch_state');
            $table->string('branch');
            $table->string('branch_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('recipientmaster', function($table) {
            $table->dropColumn('middle_name');
            $table->dropColumn('address_1');
            $table->dropColumn('address_2');
            $table->dropColumn('suburb');
            $table->dropColumn('phone_no');
            $table->dropColumn('email');
            $table->dropColumn('region');
            $table->dropColumn('branch_state');
            $table->dropColumn('branch');
            $table->dropColumn('branch_code');
        });
    }

}
