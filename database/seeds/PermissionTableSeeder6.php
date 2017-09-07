<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder6 extends Seeder
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
            'id' => 33,
        		'name' => 'tools-user_assigned-transfer',
        		'display_name' => 'Tools update project transfer user assigned',
        		'description' => 'Allow to transfer the user assigned to a project'
        	]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
