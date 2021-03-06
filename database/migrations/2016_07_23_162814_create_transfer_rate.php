<?php
// generated using: ./artisan make:migration --create='users' create_users_table
// file : databases/xxxx_xx_xx_xxxxxx_create_users_table
 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
 
class CreateTransferRate extends Migration {
 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferrate', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('country_id');                       
            $table->string('currency_code');                       
            $table->float('from');            
            $table->float('to');
            $table->float('rate');
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
        Schema::drop('transferrate');
    }
 
}