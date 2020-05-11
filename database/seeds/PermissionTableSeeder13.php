<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder13 extends Seeder
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
                'id' => 43,
                'name' => 'projectRevenue-create',
                'display_name' => 'Project Revenue create',
                'description' => 'Allow to create revenue for projects',
            ],
            [
                'id' => 44,
                'name' => 'projectRevenue-edit',
                'display_name' => 'Project Revenue edit',
                'description' => 'Allow to edit revenue for projects',
            ],
            [
                'id' => 45,
                'name' => 'projectRevenue-delete',
                'display_name' => 'Project Revenue delete',
                'description' => 'Allow to delete revenue for projects',
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
