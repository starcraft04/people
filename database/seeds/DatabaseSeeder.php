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
		$this->command->info('Permissions table seeded1!');
		$this->call('PermissionTableSeeder2');
		$this->command->info('Permissions table seeded2!');
		$this->call('PermissionTableSeeder3');
		$this->command->info('Permissions table seeded3!');
		$this->call('PermissionTableSeeder4');
		$this->command->info('Permissions table seeded4!');
		$this->call('PermissionTableSeeder5');
		$this->command->info('Permissions table seeded5!');
		$this->call('PermissionTableSeeder6');
		$this->command->info('Permissions table seeded6!');
		$this->call('PermissionTableSeeder7');
		$this->command->info('Permissions table seeded7!');
		$this->call('PermissionTableSeeder8');
		$this->command->info('Permissions table seeded8!');
		$this->call('PermissionTableSeeder9');
		$this->command->info('Permissions table seeded9!');
		$this->call('PermissionTableSeeder10');
		$this->command->info('Permissions table seeded10!');
		$this->call('PermissionTableSeeder11');
		$this->command->info('Permissions table seeded11!');
		$this->call('PermissionTableSeeder12');
		$this->command->info('Permissions table seeded12!');
		$this->call('RoleTableSeeder');
		$this->command->info('Roles table seeded!');
		$this->call('SkillsTableSeeder');
		$this->command->info('Skill table seeded!');
	}
}
