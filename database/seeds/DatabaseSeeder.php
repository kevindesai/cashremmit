<?php

use Illuminate\Database\Seeder;
use AdminUserSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminUserSeeder::class);
    }
}
