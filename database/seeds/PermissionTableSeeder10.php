<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder10 extends Seeder
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
        		'id' => 38,
        		'name' => 'home-extrainfo',
        		'display_name' => 'Home extra info',
        		'description' => 'Show extra info on the home page'
            ]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
