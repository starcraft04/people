<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder23 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
              'id' => 65,
              'name' => 'tools-update-existing_prime_code',
              'display_name' => 'Allow to update existing Prime code',
              'description' => 'Allow to update prime code and meta-activity in case it was already used and found in a Prime upload'
              ],
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
