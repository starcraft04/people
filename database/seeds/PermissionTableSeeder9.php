<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder9 extends Seeder
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
        		'id' => 37,
        		'name' => 'skills-addnew',
        		'display_name' => 'Add new skills',
        		'description' => 'Allow to add and edit new skills'
            ]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
