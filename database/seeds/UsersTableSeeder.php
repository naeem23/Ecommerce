<?php


use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => '1',
            'name' => 'Mr. Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('test1234')
        ]);

        User::create([
            'role_id' => '2',
            'name' => 'Mr. User',
            'email' => 'user@user.com',
            'password' => bcrypt('test1234')
        ]);
    }
}
