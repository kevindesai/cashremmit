<?php

use Illuminate\Database\Seeder;
//use AdminUserSeeder;
use Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
Model::unguard();
         $this->call(AdminUserSeeder::class);
 Model::reguard();
    }
}
