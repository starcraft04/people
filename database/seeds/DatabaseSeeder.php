<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $this->call('PermissionTableSeeder26');
        $this->call('PermissionTableSeeder27');
        $this->command->info('Permissions table seeded!');
        $this->call('RoleTableSeeder2');
        $this->command->info('Roles table seeded!');
        $this->call('UsersTableSeeder');
        $this->command->info('Users table seeded!');
    }
}
