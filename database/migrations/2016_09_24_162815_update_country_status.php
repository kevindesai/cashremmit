

<?php

// generated using: ./artisan make:migration --create='users' create_users_table
// file : databases/xxxx_xx_xx_xxxxxx_create_users_table

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCountryStatus extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('country', function($table) {
            $table->tinyInteger('status')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('country', function($table) {
            $table->dropColumn('status');
        });
    }

}
