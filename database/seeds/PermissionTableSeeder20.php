<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder20 extends Seeder
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
        		'id' => 54,
        		'name' => 'tools-projects-comments',
        		'display_name' => 'View & add comments',
        		'description' => 'Allow to view and add comments'
            ]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
