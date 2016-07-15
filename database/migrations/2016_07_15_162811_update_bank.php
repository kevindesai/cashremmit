<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBank extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('banks', function($table) {
            $table->dropColumn('branch');
            $table->dropColumn('bank_code');
            $table->text('attributes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('banks', function($table) {
            $table->dropColumn('attributes');
        });
    }

}
