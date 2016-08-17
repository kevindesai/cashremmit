

<?php

// generated using: ./artisan make:migration --create='users' create_users_table
// file : databases/xxxx_xx_xx_xxxxxx_create_users_table

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddIsVerifiedUser extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function($table) {
            $table->integer('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function($table) {
            $table->dropColumn('is_verified');
        });
    }

}
