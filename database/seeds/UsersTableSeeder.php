<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
                'id' => '1',
                'name' => 'admin',
                'email' => 'admin@orange.com',
                'password' => bcrypt('***Change your Password here***'),
                'is_manager' => 0,
            ]);
    }
}
