<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder11 extends Seeder
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
                'id' => 39,
                'name' => 'tools-usersskills-view-all',
                'display_name' => 'Tools users skills display all users',
                'description' => 'Allow to display the users skills for all users',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
