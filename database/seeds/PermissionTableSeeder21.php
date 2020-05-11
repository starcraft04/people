<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder21 extends Seeder
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
                'id' => 55,
                'name' => 'tools-user-summary',
                'display_name' => 'View user summary',
                'description' => 'Allow to view the user summary',
            ],
            [
                'id' => 56,
                'name' => 'action-create',
                'display_name' => 'Create actions',
                'description' => 'Allow to create an action',
            ],
            [
                'id' => 57,
                'name' => 'action-edit',
                'display_name' => 'Edit actions',
                'description' => 'Allow to edit an action',
            ],
            [
                'id' => 58,
                'name' => 'action-delete',
                'display_name' => 'Delete actions',
                'description' => 'Allow to delete an action',
            ],
            [
                'id' => 59,
                'name' => 'action-all',
                'display_name' => 'Work on all actions',
                'description' => 'Allow to work on all actions',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
