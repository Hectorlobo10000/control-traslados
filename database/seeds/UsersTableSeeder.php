<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' =>  'Admin',
            'email' => 'Admin@gmail.com',
            'avatar' => 'avatar.svg',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'enable' => true,
            'role_id' => 1,
            'branch_office_id' => 1,
            'remember_token' => Str::random(10),
        ]);

        factory(App\User::class, 3)->create();
    }
}
