<?php
//namespace 
use Illuminate\Database\Seeder;
use App\AdminUser as AU;

class AdminUserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // $this->call(AdminUserSeeder::class);
        DB::table('adminuser')->delete();

        AU::create(array(
            'name' => 'Admin',
            'is_active' => '1',
            'email' => 'admin@gmail.com',
            'password' =>  Hash::make('admin'),
        ));
    }

}
