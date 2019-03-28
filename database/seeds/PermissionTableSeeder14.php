<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder14 extends Seeder
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
        		'id' => 46,
        		'name' => 'dashboardRevenue-view',
        		'display_name' => 'Dashboard Revenue view',
        		'description' => 'Allow to view the revenue dashboard'
            ],
            [
        		'id' => 47,
        		'name' => 'dashboardOrder-view',
        		'display_name' => 'Dashboard Order view',
        		'description' => 'Allow to view the order dashboard'
            ]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
