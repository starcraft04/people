<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder4 extends Seeder
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
            'id' => 31,
                'name' => 'tools-user_assigned-remove',
                'display_name' => 'Tools update project remove user assigned',
                'description' => 'Allow to remove the user assigned to a project',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
