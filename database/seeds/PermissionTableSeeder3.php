<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder3 extends Seeder
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
            'id' => 30,
                'name' => 'tools-user_assigned-change',
                'display_name' => 'Tools update project change user assigned',
                'description' => 'Allow to change the user assigned to a project',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
