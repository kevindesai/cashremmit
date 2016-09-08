

<?php

// generated using: ./artisan make:migration --create='users' create_users_table
// file : databases/xxxx_xx_xx_xxxxxx_create_users_table

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransactionSwitch extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('transactions', function($table) {
            $table->string('switch_status');
            $table->string('switch_transaction_id');
            $table->text('switch_response');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('transactions', function($table) {
            $table->dropColumn('switch_status');
            $table->dropColumn('switch_transaction_id');
            $table->dropColumn('switch_response');
        });
    }

}
