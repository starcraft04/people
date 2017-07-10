<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		$this->call('UsersTableSeeder');
		$this->command->info('Users table seeded!');
		$this->call('PermissionTableSeeder');
		$this->command->info('Permissions table seeded!');
		$this->call('PermissionTableSeeder2');
		$this->command->info('Permissions table seeded!');
		$this->call('PermissionTableSeeder3');
		$this->command->info('Permissions table seeded!');
		$this->call('PermissionTableSeeder4');
		$this->command->info('Permissions table seeded!');
		$this->call('PermissionTableSeeder5');
		$this->command->info('Permissions table seeded!');
		$this->call('RoleTableSeeder');
		$this->command->info('Roles table seeded!');
	}
}
