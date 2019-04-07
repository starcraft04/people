<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Admin
		User::create(array(
				'id' => '1',
				'name' => 'admin',
				'email' => 'admin@orange.com',
				'password' => bcrypt('***Change your Password here***'),
				'is_manager' => 0
			));
	}
}
