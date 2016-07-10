<?php
//namespace 
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
//         $this->call(AdminUserSeeder::class);
        DB::table('adminuser')->delete();

        \App\AdminUser::create(array(
            'name' => 'Admin',
            'is_active' => '1',
            'email' => 'admin@admin.com',
            'password' => base64_encode('admin'),
        ));
    }

}
