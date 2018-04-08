<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder8 extends Seeder
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
        		'id' => 35,
        		'name' => 'tools-usersskills',
        		'display_name' => 'Tools users skills display',
        		'description' => 'Allow to display the users skills'
            ],
            [
        		'id' => 36,
        		'name' => 'tools-usersskills-editall',
        		'display_name' => 'Tools users skills edit all',
        		'description' => 'Allow to edit all the users skills'
            ]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
