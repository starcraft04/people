<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder25 extends Seeder
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
        		'id' => 72,
        		'name' => 'projectLoe-dashboard_view',
        		'display_name' => 'Dashboard Loe view',
        		'description' => 'Allow to view the LoE dashboard'
            ],
            [
        		'id' => 73,
        		'name' => 'projectLoe-signoff',
        		'display_name' => 'Project Loe allow signoff',
        		'description' => 'Allow to signoff Loe'
            ]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
